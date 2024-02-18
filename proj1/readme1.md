## Implementační dokumentace k 1. úloze do IPP 2023/2024  
Jméno a příjmení: Ondřej Novotný, 
Login: xnovot2p

### Zpracování vstupu
Vstup načítám z stdinu pomocí knihovny `sys` a ještě zkouším najít argument --help pokud najdu vypíšu jak script funguje 
v rámci vstupů a parametrů vyžadovaných zadáním.

### Validace opcodes
V rámci zadání bylo řečeno že vstup má být case insensitive tuto problematiku zpracovává můj script tak že nastavím 
veškeré opcode prvky pomocí funkce `upper()` na velká písmena a následně si pomocí pole správných prvků vyhledám že se
prvek v poli nachází pokud ano vše v pořádku a můžu pokračovat pokud ne končí program v ten moment chybou 22.

### Validace argumentů
probíhá ihned po zkontrolování všech opcodes zkontroluje pokud má @čkovou část a na tom základě kontroluje o jaký typ
argumentu se jedná a podle toho pak probíhá následná analýza.

### Validace jednotlivých instrukcí
Když už máme zvalidované jednotlivé opcodes a argumenty vezmu si Třídu Instruction a její prvky ve kterých se nachází
na základě opcodes si procházím všechny dostupné argumenty a kontroluji že pro danný opcode je jich správný počet a 
správné typy na správných pozicích.

### Tvorba XML výstupu
na vytvoření XML výstupu je využíváno `xml.etree.ElementTree` a na "zkrášlení" vytvořeného xml využívám `xml.dom.minidom`
A pro zobrazení správné hlavičky odseknu od finálního xml výstupu první řádek a nahradím ho svým korektním xml headerem 
s UTF-8 encodingem.

### Využití Regexů
Pro validaci Stringů, intů, boolů a identifikátorů využívám v projektu regex pro rychlou a kvalitní matchování znaků
`ArgReg = r"([a-zA-z_-$&%*!?][a-zA-Z0-9_-$&%*!?]*)"`

### Využití objektově orientovaného programování
Jak už bylo zmíněno v projektu používám pro Instrukce strukturu ve které uchovávám opcode a strukturu argumentů.

