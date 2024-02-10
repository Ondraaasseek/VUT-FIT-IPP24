import sys

class Argument:
    def __init__(self, args, type):
        self.args = args
        self.type = type

class Instruction:
    def __init__(self, opcode, *args):
        self.opcode = opcode
        self.args = [Argument(arg, type) for arg in args]


args = sys.argv
if len(args) != 1:
    if args[1] == "--help":
        if len(args) > 2 or sys.stdin == 0:
            sys.exit(10)
        print("--help | Vypíše tuto zprávu")
        sys.exit(0)

for line in sys.stdin:
    tokens = line.split()
    for i in range(0, len(tokens)):
        if tokens[i].__contains__("#"):
            tokens = tokens[:i]
            break
    # Skiping empty lines or just comment lines




