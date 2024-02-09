import sys

args = sys.argv
if len(args) != 1:
    if args[1] == "--help":
        if len(args) > 2:
            sys.exit(10)
        print("help:")

hasHeader = False
for line in sys.stdin:
    tokens = line.split()
    for i in range(0, len(tokens)):
        if tokens[i].__contains__("#"):
            tokens = tokens[:i]
            break

    # First we need to check for .IPPcode24 Header
    print(len(tokens), hasHeader, tokens)
    if hasHeader == False and len(tokens) == 1 and tokens[0] == ".IPPcode24":
        hasHeader = True
        break
    elif hasHeader == False:
        sys.exit(21)
    else:
        # We found header or returned err 21, so now it's time to look for other funny instruction and validate them
        print("Are we happy?")

