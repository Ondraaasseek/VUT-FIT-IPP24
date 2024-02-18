import sys
import xml.etree.ElementTree as ET
import xml.dom.minidom
import re

class ErrCode:
    tooManyArgs = 10
    missingHeader = 21
    wrongOpcode = 22
    lexSyntax = 23

class Argument:
    def __init__(self, arg, type):
        self.arg = arg
        self.type = type

class Instruction:
    def __init__(self, opcode, *args):
        self.opcode = opcode
        self.args = [Argument(arg, None) for arg in args]

lines = []
args = sys.argv
if len(args) != 1:
    if args[1] == "--help":
        if len(args) > 2 or sys.stdin == 0:
            sys.exit(ErrCode.tooManyArgs)
        print("--help | Vypíše tuto zprávu")
        sys.exit(0)

for line in sys.stdin:
    line = line.split("#")[0]
    tokens = line.split()
    for i in range(0, len(tokens)):
        if tokens[i].__contains__("#"):
            tokens[i] = tokens[i].split("#")[0]
            break
    if len(tokens) == 0:
        # Skiping empty lines or just comment lines
        continue
    lines.append(tokens)

# Check for .IPPcode24
if len(lines) == 0 or not(lines[0][0].__contains__(".IPPcode24")):
    sys.exit(ErrCode.missingHeader)
# If present, remove the .IPPcode24 line
lines.pop(0)

# Put the instructions into a list of Instruction objects
instructions = []
for line in lines:
    opcode = line[0]
    args = line[1:]
    instructions.append(Instruction(opcode, *args))

validOpCodes = ["MOVE", "CREATEFRAME", "PUSHFRAME", "POPFRAME", "DEFVAR", "CALL", "RETURN", "PUSHS", "POPS", "ADD", "SUB", "MUL", "IDIV", "LT", "GT", "EQ", "AND", "OR", "NOT", "INT2CHAR", "STRI2INT", "READ", "WRITE", "CONCAT", "STRLEN", "GETCHAR", "SETCHAR", "TYPE", "LABEL", "JUMP", "JUMPIFEQ", "JUMPIFNEQ", "DPRINT", "BREAK"]
# Validate the opcode
for instruction in instructions:
    if instruction.opcode.upper() not in validOpCodes:
        if instruction.opcode.__contains__(".IPPcode24"):
            sys.exit(ErrCode.lexSyntax)
        sys.exit(ErrCode.wrongOpcode)
    instruction.opcode = instruction.opcode.upper()

# Set argument types 
for instruction in instructions:
    for arg in instruction.args:
        if instruction.opcode in ["JUMP", "LABEL", "CALL"]:
            arg.type = "label"
            continue
        if "GF" in arg.arg[:2] or "LF" in arg.arg[:2] or "TF" in arg.arg[:2]:
            arg.type = "var"
            ArgReg = r"([a-zA-Z_\-&%*$!?][a-zA-Z0-9_\-&%*$!?]*)"
            if not(re.match(ArgReg, arg.arg)):
                sys.exit(ErrCode.lexSyntax)
            continue
        elif arg.arg == "int":
            arg.type = "type"
            continue
        elif arg.arg == "bool":
            arg.type = "type"
            continue
        elif arg.arg == "string":
            arg.type = "type"
            continue
        elif "string@" in arg.arg:
            arg.type = "string"
            arg.arg = arg.arg[7:]
            # Checking for bad escape chars
            StringReg = r""
            if re.match(StringReg, arg.arg):
                sys.exit(ErrCode.lexSyntax)
            continue
        elif "int@" in arg.arg:
            arg.type = "int"
            arg.arg = arg.arg[4:]
            # Number regex pattern
            DecReg = r"(^[+-]?[0-9]+$)"
            OctReg = r"(^[+-]?(0o)[0-7]+$)"
            HexReg = r"(^[+-]?[(0x)0-9a-fA-F]+$)"
            if not(re.match(DecReg, arg.arg) or re.match(OctReg, arg.arg) or re.match(HexReg, arg.arg)):
                sys.exit(ErrCode.lexSyntax)
            continue
        elif "bool@" in arg.arg:
            arg.type = "bool"
            arg.arg = arg.arg[5:]
            if not (arg.arg == "true" or arg.arg == "false"):
                sys.exit(ErrCode.lexSyntax)
            continue
        elif "nil@" in arg.arg:
            arg.type = "nil"
            arg.arg = arg.arg[4:]
            if not (arg.arg == "nil"):
                sys.exit(ErrCode.lexSyntax)
        else:
            arg.type = "label"
# Check for correct number and types of arguments
for instruction in instructions:
    if instruction.opcode in ["MOVE", "INT2CHAR", "STRLEN", "TYPE"]:
        if len(instruction.args) != 2:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[1].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["CREATEFRAME", "PUSHFRAME", "POPFRAME", "RETURN", "BREAK"]:
        if len(instruction.args) != 0:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["DEFVAR", "POPS"]:
        if len(instruction.args) != 1:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["CALL", "LABEL", "JUMP"]:
        if len(instruction.args) != 1:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "label":
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["PUSHS", "WRITE", "DPRINT"]:
        if len(instruction.args) != 1:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["ADD", "SUB", "MUL", "IDIV", "LT", "GT", "EQ", "AND", "OR", "GETCHAR", "SETCHAR", "CONCAT", "STRI2INT"]:
        if len(instruction.args) != 3:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[1].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[2].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["NOT"]:
        if len(instruction.args) != 2:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[1].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["JUMPIFEQ", "JUMPIFNEQ"]:
        if len(instruction.args) != 3:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "label":
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[1].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[2].type not in ["int", "string", "bool", "var", "nil"]:
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["EXIT"]:
        if len(instruction.args) != 1:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
    elif instruction.opcode in ["READ"]:
        if len(instruction.args) != 2:
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[0].type != "var":
            sys.exit(ErrCode.lexSyntax)
        if instruction.args[1].type != "type":
            sys.exit(ErrCode.lexSyntax)
    else:
        sys.exit(ErrCode.lexSyntax)

# Everything is OK we can begin XMLization
root = ET.Element("program")
root.set("language", "IPPcode24")

for instruction in instructions:
    instr = ET.SubElement(root, "instruction")
    instr.set("order", str(instructions.index(instruction) + 1))
    instr.set("opcode", instruction.opcode)

    for arg in instruction.args:
        argEl = ET.SubElement(instr, "arg" + str(instruction.args.index(arg) + 1))
        argEl.set("type", arg.type)
        argEl.text = arg.arg

xml_string = ET.tostring(root, encoding="utf-8")
dom = xml.dom.minidom.parseString(xml_string)
formatted_xml = dom.toprettyxml(indent="    ")

declaration = '<?xml version="1.0" encoding="UTF-8"?>\n'
postString = formatted_xml.split("\n",1)[1]
formatted_xml = declaration + postString

sys.stdout.buffer.write(formatted_xml.encode("utf-8"))
sys.exit(0)