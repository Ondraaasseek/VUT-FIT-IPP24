## Implementační dokumentace ke druhé úloze do předmětu IPP 2023/2024
Jméno a příjmení: **Ondřej Novotný** \
Login: **xnovot2p**

### Obecné informace o implementaci
Program implementuje interpreter do předmětu IPP, navazující na `parse.py`. Je napsán v jazyce PHP8.3, a je rozdělen 
do několika tříd. Vstupní bod programu je soubor `interpret.php`, který přebírá řízení od Interpreteru z ipp-core. 
Program je logicky rozdělen do tříd, které se starají o různé části interpretace.

### Třídy
- interpreter - třída, která validuje vstupní xml strukturu, stará se o řízení a zajištuje pro jednotlivé instrukce 
logickou spojku. Zadržuje rovněž struktury, které by mohla instrukce potřebovat.
- frame - třída, která reprezentuje rámec. Obsahuje metody pro práci s proměnnými v rámci.
- stack - třída, která reprezentuje zásobník. Obsahuje metody pro práci s proměnnými na zásobníku.
- variable - třída, která reprezentuje proměnnou. Obsahuje metody pro práci s proměnnou.
- frame controller - třída, která slouží pro zadržování dat pro rámce a zásobník. Obsahuje metody pro práci s rámci a zásobníkem.
Rovněž uchovává potřebné funkce pro zápis a čtení ze struktur.
- instruction factory - třída, která slouží pro vytváření instrukcí.
- instruction - třída, která reprezentuje instrukci. Obsahuje metody pro zpracování instrukce a získání jejích argumentů.

### Validace vstupního xml
Vstupní xml je validováno uvnitř `interpreter.php`. Na začátku validace je kontrolována hlavička programu, validní instrukční tagy, 
validní pořadí a validní tagy argumentu. Pokud by cokoliv z těchto zmíněných bylo nevalidní, interpreter skončí s chybou 32 
nevalidní XML struktura.


### Implementace objektové továrny
Objektová továrna je implementována pomocí metody createInstance, která vytváří instrukce na základě zadaného názvu instrukce.
Pokud instrukce neexistuje, je vyhozena výjimka. Továrna je implementována jako statická třída, která nemá žádné instance.

```php
public static function createInstance(string $opCode, array $args): Instruction{...}
```

### Implementace instrukcí
Instrukce je implementována jako abstraktní třída, která obsahuje metody pro zpracování instrukce, které si pak každá instance
implementuje sama. Následně stačí pouze zavolat metodu execute a instrukce se provede. Z hlediska programátora je toto velmi
přehledné a jednoduché.
```php
abstract Class Instruction{...}
```

### Implementace rámcového ovladače
Rámcový ovladač je implementován jako třída, která obsahuje metody pro vytvoření a práci se všemi třemi typy rámců, 
zásobníků a všech polí, které byly třeba pro implementaci interpreteru. Rovněž obsahuje odkaz na `InputReader` a všechny 
ostatní funkce. Rámcový ovladač je implementován jako singleton, aby bylo možné získat instanci rámcového ovladače
kdekoliv v programu.

```php
class FrameController{...}
```

### Implementace rámcové logiky
Rámec je implementován obecně, aby mohl být následně v rámcovém ovladači zastoupen jako dočasný rámec pole 
lokálních rámců a globální rámec. V rámci mám implementovanou defaultní funkci __toString, která danné proměnné v rámci 
přepíše do řetězcové podoby pro jednoduché zobrazení v break instrukci a exit instrukci.
Následně obsahuje addVariable pro přidání proměnné do rámce a hasVariable a getVariable.

```php
class Frame{...}
```

### Implementace zásobníku
Zásobník je implementován pomocí pole, ke kterému se přistupuje pomocí funkcí pop, push, top a empty. Zásobník je nejvíce využit
na zásobník volání, a pro instrukce, které využívají zásobník jako pops a pushs.

```php
class Stack{...}
```

### Implementace proměnných
Proměnné jsou implementovány jako dva řetězce a mixed proměnná, která uchovává hodnotu proměnné. Proměnné jsou následně 
využity v rámcích, které jsou zde uloženy.
```php
class Variable{...}
```

### Celkové zhodnocení implementace
Implementace je velmi přehledná a jednoduchá. Každá třída má jasně definované metody a zodpovědnosti. Díky tomu je 
velmi přehledná a snadno rozšiřitelná. Implementace je relativně modulární, proto by ji šlo v budoucnu snadno rozšířit o další
instrukce, nebo třídy podle potřeby.

### Závěr
Projekt jako celek prošel statickou analýzou a testováním na serveru Merlin. Všechny testy byly úspěšně otestovány a
program byl úspěšně odevzdán. Program je napsán v souladu s dokumentací a je plně funkční.

### Diagram
![Diagram](./diagram.png)
