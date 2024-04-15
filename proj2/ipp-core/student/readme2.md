## Implementační dokumentace ke druhé úloze do předmětu IPP 2023/2024
Jméno a příjmení: Ondřej Novotný
Login: xnovot2p

### Obecné informace o implementaci
Program je napsán v jazyce PHP8.3 a je rozdělen do několika tříd. Vstupní bod programu je soubor interpret.php, který
přebírá řízení od Interpreteru z ipp-core. Program je logicky rozdělen do tříd, které se starají o různé části interptetace.

### Třídy
- interpreter - Třída která se stará o řízení a zajištuje pro jednotlivé instrukce logickou spojku. Zadržuje rovněž 
struktury které by mohla instrukce potřebovat.
- frame - Třída která reprezentuje rámec. Obsahuje metody pro práci s proměnnými v rámci.
- stack - Třída která reprezentuje zásobník. Obsahuje metody pro práci s proměnnými na zásobníku.
- variable - Třída která reprezentuje proměnnou. Obsahuje metody pro práci s proměnnou.
- Frame controller - Třída která slouží pro zadržování dat pro rámce a zásobník. Obsahuje metody pro práci s rámci a zásobníkem.
rovněž uchovává potřebné struktury pro zápis pro čtení a další.
- Instruction factory - Třída která slouží pro vytváření instrukcí. Obsahuje metody pro vytváření instrukcí.
- instruction - Třída která reprezentuje instrukci. Obsahuje metody pro zpracování instrukce a získání jejích argumentů.

### Implementace objektové továrny
Objektová továrna je implementována pomocí metody createInstance, která vytváří instrukce na základě zadaného názvu instrukce.
Pokud instrukce neexistuje, je vyhozena výjimka. Továrna je implementována jako statická třída, která nemá žádné instance.

### Implementace instrukcí
Instrukce je implementována jako abstraktní třída, která obsahuje metody pro zpracování instrukce které si pak každá instance
implementuje sama. Tudíž poté stačí jen zavolat metodu execute a instrukce se provede. A z hlediska programátora je toto velmi
přehledné a jednoduché.



