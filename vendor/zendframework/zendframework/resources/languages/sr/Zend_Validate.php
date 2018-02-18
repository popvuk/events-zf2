<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * EN-Revision: 21135
 */
return array(
    // Zend_Validate_Alnum
    "Invalid type given, value should be float, string, or integer" => "Nevalidan tip, vrednost treba da bude tekst ili broj",
    "'%value%' contains characters which are non alphabetic and no digits" => "'%value%' sadrÅ¾i karaktere koji nisu slova niti cifre",
    "'%value%' is an empty string" => "'%value%' je prazan tekst",

    // Zend_Validate_Alpha
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "'%value%' contains non alphabetic characters" => "'%value%' sadrÅ¾i karaktere koji nisu slova",
    "'%value%' is an empty string" => "'%value%' je prazan tekst",

    // Zend_Validate_Barcode
    "'%value%' failed checksum validation" => "'%value%' greÅ¡ka u checksum validaciji",
    "'%value%' contains invalid characters" => "'%value%' sadrÅ¾i nevalidne karaktere",
    "'%value%' should have a length of %length% characters" => "'%value%' treba da bude duÅ¾ine %length%",
    "Invalid type given, value should be string" => "Nevalidan tip, vrednost treba da bude tekst",

    // Zend_Validate_Between
    "'%value%' is not between '%min%' and '%max%', inclusively" => "'%value%' nije izmeÄ‘u '%min%' i '%max%', ukljuÄ�ivo",
    "'%value%' is not strictly between '%min%' and '%max%'" => "'%value%' nije strogo izmeÄ‘u '%min%' i '%max%'",

    // Zend_Validate_Callback
    "'%value%' is not valid" => "'%value%' nije validno",
    "Failure within the callback, exception returned" => "GreÅ¡ka u pozivu",

    // Zend_Validate_Ccnum
    "'%value%' must contain between 13 and 19 digits" => "'%value%' treba da sadrÅ¾i izmeÄ‘u 13 i 19 cifara",
    "Luhn algorithm (mod-10 checksum) failed on '%value%'" => "Luhn algoritam ne prolazi na '%value%'",

    // Zend_Validate_CreditCard
    "Luhn algorithm (mod-10 checksum) failed on '%value%'" => "Luhn algoritam ne prolazi na '%value%'",
    "'%value%' must contain only digits" => "'%value%' treba da sadrÅ¾i samo cifre",
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "'%value%' contains an invalid amount of digits" => "'%value%' sadrÅ¾i nevalidu koliÄ�inu cifara",
    "'%value%' is not from an allowed institute" => "'%value%' nije iz dozvoljene institucije",
    "Validation of '%value%' has been failed by the service" => "Validacija '%value%' nije uspela od strane servisa",
    "The service returned a failure while validating '%value%'" => "Servis je vratio greÅ¡ku pri validaciji '%value%'",

    // Zend_Validate_Date
    "Invalid type given. String, integer, array or DateTime expected" => "Nevalidan tip, vrednost treba da bude tekst, ceo broj, niz ili datum",
    "The input does not appear to be a valid date" => "Unos nije validan datum",
    "The input does not fit the date format '%format%'" => "Unos nije u formatu datuma '%format%'",

    // Zend_Validate_Db_Abstract
    "No record matching %value% was found" => "Zapis koji se poklapa sa %value% nije pronaÄ‘en",
    "A record matching %value% was found" => "Zapis koji se poklapa sa %value% je pronaÄ‘en",

    // Zend_Validate_Digits
    "Invalid type given, value should be string, integer or float" => "Nevalidan tip, vrednost treba da bude tekst ili broj",
    "'%value%' contains characters which are not digits; but only digits are allowed" => "'%value%' sadrÅ¾i karaktere koji nisu cifre, a samo cifre su dozvoljene",
    "'%value%' contains not only digit characters" => "'%value%' ne sadrÅ¾i samo cifre",
    "'%value%' is an empty string" => "'%value%' je prazan tekst",

    // Zend_Validate_EmailAddress
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "The input is not a valid email address. Use the basic format local-part@hostname" => "Unos nije validna adresa elektronske pošte. Koristi osnovni format adrese adresa@imehosta",
    "'%hostname%' is not a valid hostname for the email address" => "'%hostname%' nije validno ime hosta za adresu elektronske pošte",
    "'%hostname%' does not appear to have a valid MX record for the email address" => "'%hostname%' nema validan MX zapis za adresu elektronske pošte ",
    "'%hostname%' is not in a routable network segment. The email address should not be resolved from public network." => "'%hostname%' nije rutabilan mrežni segment. Adresa elektronske pošte ne treba da bude razrešena sa javne mreže",
    "'%localPart%' can not be matched against dot-atom format" => "'%localPart%' se ne poklapa sa dot-atom formatom",
    "'%localPart%' can not be matched against quoted-string format" => "'%localPart%' se ne poklapa sa quoted-string formatom",
    "'%localPart%' is not a valid local part for email address " => "'%localPart%' nije validan deo adrese elektronske pošte ",
    "The input exceeds the allowed length" => "Unos prelazi dozvoljenu dužinu",

    // Zend_Validate_File_Count
    "Too many files, maximum '%max%' are allowed but '%count%' are given" => "Preveliki broj fajlova, maksimalno '%max%' je dozvoljeno, a '%count%' je prosleÄ‘eno",
    "Too few files, minimum '%min%' are expected but '%count%' are given" => "Premali broj fajlova, minimalno '%min%' je oÄ�ekivano, a '%count%' je prosleÄ‘eno",

    // Zend_Validate_File_Crc32
    "File '%value%' does not match the given crc32 hashes" => "Fajl '%value%' ne prolazi crc32 proveru",
    "A crc32 hash could not be evaluated for the given file" => "Nema crc32 kodova za dati fajl",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_File_ExcludeExtension
    "File '%value%' has a false extension" => "Fajl '%value%' ima nevalidnu ekstenziju",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_File_ExcludeMimeType
    "File '%value%' has a false mimetype of '%type%'" => "Fajl '%value%' ima nevalidan mime-tip '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Mime-tip fajla '%value%' ne moÅ¾e biti detektovan",
    "File '%value%' can not be read" => "Fajl '%value%' ne moÅ¾e biti proÄ�itan",

    // Zend_Validate_File_Exists
    "File '%value%' does not exist" => "Fajl '%value%' ne postoji",

    // Zend_Validate_File_Extension
    "File has an incorrect extension" => "Fajl ima nevalidnu ekstenziju",
    "File is not readable or does not exist" => "Fajl nije čitljiv ili ne može biti pronađen",

    // Zend_Validate_File_FilesSize
    "All files in sum should have a maximum size of '%max%' but '%size%' were detected" => "Svi fajlovi u zbiru treba da imaju maksimalnu veličinu '%max%', veličina poslatih fajlova je '%size%'",
    "All files in sum should have a minimum size of '%min%' but '%size%' were detected" => "Svi fajlovi u zbiru treba da imaju minimalnu veličinu '%min%', veličina poslatih fajlova je '%size%'",
    "One or more files can not be read" => "Jedan ili više fajlova ne može biti pročitan",

    // Zend_Validate_File_Hash
    "File '%value%' does not match the given hashes" => "Fajl '%value%' je nepravilno kodiran",
    "A hash could not be evaluated for the given file" => "HeÅ¡evi nisu pronaÄ‘eni za dati fajl",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_File_ImageSize
    "Maximum allowed width for image '%value%' should be '%maxwidth%' but '%width%' detected" => "Maksimalna dozvoljena Å¡irina slike '%value%' je '%maxwidth%', data slika ima Å¡irinu '%width%'",
    "Minimum expected width for image '%value%' should be '%minwidth%' but '%width%' detected" => "Minimalna oÄ�ekivana Å¡irina slike '%value%' je '%minwidth%', data slika ima Å¡irinu '%width%'",
    "Maximum allowed height for image '%value%' should be '%maxheight%' but '%height%' detected" => "Maksimalna dozvoljena visina slike '%value%' je '%maxheight%', data slika ima visinu '%height%'",
    "Minimum expected height for image '%value%' should be '%minheight%' but '%height%' detected" => "Minimalna oÄ�ekivana visina slike '%value%' je '%minheight%', data slika ima visinu '%height%'",
    "The size of image '%value%' could not be detected" => "VeliÄ�ina slike '%value%' ne moÅ¾e biti odreÄ‘ena",
    "File '%value%' can not be read" => "Fajl '%value%' ne moÅ¾e biti proÄ�itan",

    // Zend_Validate_File_IsCompressed
    "File '%value%' is not compressed, '%type%' detected" => "Fajl '%value%' nije kompresovan, '%type%' detektovan",
    "The mimetype of file '%value%' could not be detected" => "Mime-tip fajla '%value%' ne moÅ¾e biti detektovan",
    "File '%value%' can not be read" => "Fajl '%value%' ne moÅ¾e biti proÄ�itan",

    // Zend_Validate_File_IsImage
    "File '%value%' is no image, '%type%' detected" => "Fajl '%value%' nije slika, '%type%' detektovan",
    "The mimetype of file '%value%' could not be detected" => "Mime-tip fajla '%value%' ne moÅ¾e biti detektovan",
    "File '%value%' can not be read" => "Fajl '%value%' ne moÅ¾e biti proÄ�itan",

    // Zend_Validate_File_Md5
    "File '%value%' does not match the given md5 hashes" => "Fajl '%value%' ne prolazi md5 proveru",
    "A md5 hash could not be evaluated for the given file" => "Nema md5 heÅ¡eva za dati fajl",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_File_MimeType
    "File '%value%' has a false mimetype of '%type%'" => "Fajl '%value%' ima nevalidan mime-tip '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Mime-tip fajla '%value%' ne moÅ¾e biti detektovan",
    "File '%value%' can not be read" => "Fajl '%value%' ne moÅ¾e biti proÄ�itan",

    // Zend_Validate_File_NotExists
    "File '%value%' exists" => "Fajl '%value%' postoji",

    // Zend_Validate_File_Sha1
    "File '%value%' does not match the given sha1 hashes" => "Fajl '%value%' ne prolazi sha1 proveru",
    "A sha1 hash could not be evaluated for the given file" => "Nema sha1 heÅ¡eva za dati fajl",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_File_Size
    "Maximum allowed size for file is '%max%' but '%size%' detected" => "Maksimalna dozvoljena veličina fajla '%value%' je '%max%', data veličina je '%size%'",
    "Minimum expected size for file is '%min%' but '%size%' detected" => "Minimalna očekivana veličina fajla '%value%' je '%min%', data veličina je '%size%'",
    "File is not readable or does not exist" => "Fajl nije čitljiv ili ne postoji",

    // Zend_Validate_File_Upload
    "File '%value%' exceeds the defined ini size" => "Fajl '%value%' prevazilazi maksimalnu dozvoljenu veliÄ�inu",
    "File '%value%' exceeds the defined form size" => "Fajl '%value%' prevazilazi maksimalnu dozvoljenu veliÄ�inu",
    "File '%value%' was only partially uploaded" => "Fajl '%value%' je samo parcijalno uploadovan",
    "File '%value%' was not uploaded" => "Fajl '%value%' nije uploadovan",
    "No temporary directory was found for file '%value%'" => "Privremeni direktorijum nije pronaÄ‘en za fajl '%value%'",
    "File '%value%' can't be written" => "Fajl '%value%' ne moÅ¾e biti izmenjen",
    "A PHP extension returned an error while uploading the file '%value%'" => "Ekstenzija je vratila greÅ¡ku tokom uploada fajla '%value%'",
    "File '%value%' was illegally uploaded. This could be a possible attack" => "Fajl '%value%' je ilegalno uploadovan, moguÄ‡ napad",
    "File '%value%' was not found" => "Fajl '%value%' nije pronaÄ‘en",
    "Unknown error while uploading file '%value%'" => "Nepoznata greÅ¡ka pri uploadu fajla '%value%'",

    // Zend_Validate_File_WordCount
    "Too much words, maximum '%max%' are allowed but '%count%' were counted" => "PreviÅ¡e reÄ�i, maksimalno '%max%' je dozvoljeno, '%count%' je izbrojano",
    "Too few words, minimum '%min%' are expected but '%count%' were counted" => "Premalo reÄ�i, minimalno '%min%' je oÄ�ekivano, '%count%' je izbrojano",
    "File '%value%' could not be found" => "Fajl '%value%' ne moÅ¾e biti pronaÄ‘en",

    // Zend_Validate_Float
    "Invalid type given, value should be float, string, or integer" => "Nevalidan tip, vrednost treba da bude tekst ili broj",
    "'%value%' does not appear to be a float" => "'%value%' nije razlomljeni broj",

    // Zend_Validate_GreaterThan
    "'%value%' is not greater than '%min%'" => "'%value%' nije veÄ‡e od '%min%'",

    // Zend_Validate_Hex
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "'%value%' has not only hexadecimal digit characters" => "'%value%' se ne sastoji samo od heksadecimalnih karaktera",

    // Zend_Validate_Hostname
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "The input appears to be an IP address, but IP addresses are not allowed" => "'%value%' je IP adresa, IP adrese nisu dozvoljene",
    "The input appears to be a DNS hostname but cannot match TLD against known list" => "'%value%' je DNS ime hosta, ali TLD nije u listi poznatih",
    "The input appears to be a DNS hostname but contains a dash in an invalid position" => "'%value%' je DNS ime hosta, ali sadrÅ¾i srednju crtu (-) na nedozvoljenoj poziciji",
    "The input appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'" => "'%value%' je DNS ime hosta, ali se ne poklapa sa Å¡emom za '%tld%' TLD",
    "The input appears to be a DNS hostname but cannot extract TLD part" => "'%value%' je DNS ime hosta, ali ne moÅ¾e da se ekstraktuje TLD deo '%tld%'",
    "The input does not match the expected structure for a DNS hostname" => "'%value%' se ne poklapa sa očekivanom strukturom DNS imena hosta",
    "The input does not appear to be a valid local network name" => "'%value%' nije validno ime lokalne mreÅ¾e",
    "The input appears to be a local network name but local network names are not allowed" => "'%value%' je ime lokalne mreže, lokalna imena mreža nisu dozvoljena",
    "The input appears to be a DNS hostname but the given punycode notation cannot be decoded" => "'%value%' je DNS ime hosta, ali data punikod notacija ne moÅ¾e biti dekodirana",

    // Zend_Validate_Iban
    "Unknown country within the IBAN '%value%'" => "Nepoznata zemlja u IBAN '%value%'",
    "'%value%' has a false IBAN format" => "'%value%' nije u validnom IBAN formatu",
    "'%value%' has failed the IBAN check" => "'%value%' ne prolazi IBAN proveru",

    // Zend_Validate_Identical
    "The two given tokens do not match" => "Tokeni se ne poklapaju",
    "No token was provided to match against" => "Token za proveru nije prosleÄ‘en",

    // Zend_Validate_InArray
    "'%value%' was not found in the haystack" => "'%value%' nije pronaÄ‘eno u gomili",

    // Zend_Validate_Int
    "Invalid type given, value should be string or integer" => "Nevalidan tip, vrednost treba da bude tekst ili ceo broj",
    "'%value%' does not appear to be an integer" => "'%value%' nije ceo broj",

    // Zend_Validate_Ip
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "'%value%' does not appear to be a valid IP address" => "'%value%' nije validna IP adresa",

    // Zend_Validate_Isbn
    "Invalid type given, value should be string or integer" => "Nevalidan tip, vrednost treba da bude tekst ili ceo broj",
    "'%value%' is not a valid ISBN number" => "'%value%' nije validan ISBN broj",

    // Zend_Validate_LessThan
    "'%value%' is not less than '%max%'" => "'%value%' je manje od '%max%'",

    // Zend_Validate_NotEmpty
    "Invalid type given, value should be float, string, array, boolean or integer" => "Nevalidan tip, vrednost treba da bude tekst, broj ili logiÄ�ka vrednost",
    "Value is required and can't be empty" => "Vrednost je obavezna i ne sme biti prazna",

    // Zend_Validate_PostCode
    "Invalid type given. The value should be a string or an integer" => "Nevalidan tip. Vrednost treba da bude tekst ili ceo broj",
    "'%value%' does not appear to be a postal code" => "'%value%' nije poÅ¡tanski broj",

    // Zend_Validate_Regex
    "Invalid type given, value should be string, integer or float" => "Nevalidan tip, vrednost treba da bude tekst ili broj",
    "'%value%' does not match against pattern '%pattern%'" => "'%value%' se ne poklapa sa formatom '%pattern%'",
    "There was an internal error while using the pattern '%pattern%'" => "Dogodila se greÅ¡ka pri koriÅ¡Ä‡enju formata '%pattern%'",

    // Zend_Validate_Sitemap_Changefreq
    "'%value%' is not a valid sitemap changefreq" => "'%value%' nije validna frekvencija promene mape sajta",
    "Invalid type given, the value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",

    // Zend_Validate_Sitemap_Lastmod
    "'%value%' is not a valid sitemap lastmod" => "'%value%' nije validan datum izmene mape sajta",
    "Invalid type given, the value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",

    // Zend_Validate_Sitemap_Loc
    "'%value%' is not a valid sitemap location" => "'%value%' nije validna lokacija mape sajta",
    "Invalid type given, the value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",

    // Zend_Validate_Sitemap_Priority
    "'%value%' is not a valid sitemap priority" => "'%value%' nije validan prioritet mape sajta",
    "Invalid type given, the value should be an integer, a float or a numeric string" => "Nevalidan tip, vrednost treba da bude broj ili numeriÄ�ki niz",

    // Zend_Validate_StringLength
    "Invalid type given, value should be a string" => "Nevalidan tip, vrednost treba da bude tekst",
    "'%value%' is less than %min% characters long" => "'%value%' ima manje od %min% karaktera",
    "'%value%' is more than %max% characters long" => "'%value%' ima više od %max% karaktera",
    "The input is less than %min% characters long" => "Unos sadrži manje od %min% karaktera",
    "The input is more than %max% characters long" => "Unos sadrži više od %max% karaktera",
);
