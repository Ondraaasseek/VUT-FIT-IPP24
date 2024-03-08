## Implementační dokumentace k první úloze do předmětu IPP 2023/2024
Jméno a příjmení: Ondřej Novotný
Login: xnovot2p

### Obecné informace o implementaci
Program je napsán v jazyce Python 3 a využívá knihovny sys, xml.etree.ElementTree, xml.dom.minidom a re.
Řešení je rozděleno do několika částí, které se postupně vykonávají. Nejprve se zpracuje vstup, následně se provede
validace opcodes, argumentů a instrukcí. Nakonec se vytvoří XML výstup.

### Zpracování vstupu
Vstup načítám z stdinu pomocí knihovny sys a hledám argument --help. Pokud najdu argument, vypíšu jak script funguje
v rámci vstupů a parametrů vyžadovaných zadáním.

### Validace opcodes
V rámci zadání bylo řečeno, že vstup má být case insensitive. Tuto problematiku zpracovává můj script, nastavím veškeré 
opcode prvky pomocí funkce `upper()` na velká písmena, a následně si pomocí pole správných prvků vyhledám prvek v poli. 
Pokud se v poli nachází, vše je v pořádku a můžu pokračovat, pokud ne, program končí chybou 22.

### Validace argumentů
probíhá ihned po zkontrolování všech opcodes. Zkontroluje, jestli má @čkovou část, a na tom základě vyhodnotí, o jaký typ
argumentu se jedná. Podle toho pak probíhá následná analýza.

### Validace jednotlivých instrukcí
Když máme zvalidované jednotlivé opcodes a argumenty, vezmu si Třídu Instruction a její prvky ve kterých se nachází. Na 
základě opcodes si procházím všechny dostupné argumenty. Kontroluji, že je pro daný opcode správný počet a správné typy 
na správných pozicích.

### Tvorba XML výstupu
na vytvoření XML výstupu je využíváno xml.etree.ElementTree a na "zkrášlení" vytvořeného xml využívám xml.dom.minidom.

### Využití Regexů
Pro validaci Stringů, intů, boolů a identifikátorů využívám v projektu regex pro rychlou a kvalitní matchování znaků
`ArgReg = r"([a-zA-z_-$&%*!?][a-zA-Z0-9_-$&%*!?]*)`

### Využití objektově orientovaného programování
Jak už bylo zmíněno v projektu používám pro instrukce strukturu, ve které uchovávám opcode a strukturu argumentů.

