import sys

args = sys.argv
if(len(args) != 1):
    if(args[1] == "--help"):
        if(len(args) > 2):
            sys.exit(10)
        print("help:")

for line in sys.stdin:
    tokens = line.split()
    for i in range(0, len(tokens)):
        if tokens[i].__contains__("#"):
            tokens = tokens[:i]
            break
    print(tokens)

