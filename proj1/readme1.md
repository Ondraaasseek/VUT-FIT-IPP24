## Implementační dokumentace k 1. úloze do IPP 2023/2024  
Jméno a příjmení: Ondřej Novotný, 
Login: xnovot2p

### Zpracování vstupu
Vstup načítám z stdinu pomocí knihovny `sys` a ještě zkouším najít argument --help pokud najdu vypíšu jak script funguje 
v rámci vstupů a parametrů vyžadovaných.

pokud načtu pouze stdin pokračuju následovně vstup si zformátuju a ořežu o komentáře.

poté si vezmu první prvek z pole a zkontroluju že ostatní argumenty které argumentu přísluší jsou validní.

pak už jen z jednotlivých funkčních řádku vytvořím XML.

# TODO:
Add regex to match octal and hexadecimal numbers and strings
