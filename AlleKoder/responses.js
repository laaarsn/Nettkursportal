function getBotResponse(input) {


    // includes-funksjonen gjør at bruker ikke må skrive inn eksakt riktig tekststreng for å få det svaret vedkommende ønsker. 
    let kontakt = input.includes("kontakt");

    // Så lenge input inneholder ordet "kontakt" vil variabelen "kontakt" være true, og det blir returnert en tekststreng med kontaktinformajson. 
    if (kontakt == true) {
        return "Du kan ta direkte kontakt med Nettkursportalen på tlf: 48 111 529 eller mail: laarsn@gmail.com";
    }

    // Samme prinsipp som ovenfor. 
    let passord = input.includes("passord");

    if (passord == true) {
        return "Du kan bestille nytt passord <a href='http://localhost/Prosjekt/reset-password.php'>på denne siden <a/>.";
    }
    
    let tisip = input.includes("tisip");  
    let alttisip = input.includes("TISIP");
    let alttisip2 = input.includes("Tisip");

    if (tisip == true || alttisip == true || alttisip2 == true) { // Dersom funksjonen toLower() (som gjør om alt til små bokstaver) hadde tillatt parametere (input i denne funksjonen), ville jeg naturligvis brukt denne istedenfor å lage alterntive ord. :-)
        return "Tisip er en bra fagskole med flinke lærere i alle fag. :-)"; 
    }

    
    let takk = input.includes("takk");
    if (takk == true) {
        return "Bare hyggelig! RoboLars er her for å hjelpe deg. :-) For direkte henvendelser kan du ta kontakt med Nettkursportalen på mail: 'laarsn@gmail.com', eller tlf: 48 111 529.";
    } 

    let kurs = input.includes("kurs");
    if (kurs == true) {
        let tekst = "På Laarsn Nettkursportal kan man velge mellom en rekke varierte og skreddersydde kurs. Se tilgjengelige kurs <a href='http://localhost/Prosjekt/utlopt.php'>på denne siden <a/>"; 
        let tekst2 = "\neller søk etter aktuelle kurs i søkemotoren øverst i menyen :-) For å registrere deg på et kurs må du først lage deg en <a href='http://localhost/Prosjekt/regbruker.php'>bruker<a/>. ";
        return [tekst,tekst2];
    }



    let bruker = input.includes("bruker");
    if (bruker == true) {
        return "Dersom du skal lage en ny bruker må du besøke <a href='http://localhost/Prosjekt/regbruker.php'>denne siden <a/> eller klikk på 'Ny bruker?' øverst i menyen :-) ";
    }

    if (input == "stein") {
        return "papir";
    } else if (input == "papir") {
        return "saks";
    } else if (input == "saks") {
        return "stein";
    }

    let velkomst = input.includes("hei");
    let altvelkomst = input.includes("Hei");
    // Enkle responser
    if (input == "Heisann" || input == "heisann" || velkomst == true || altvelkomst == true) {
        return "Hei på deg! :-)";
    } else if (input == "Ha det bra" || input == "ha det bra" || input == "Hadet" || input == "Ha det" || input == "på gjensyn") {
        return "På gjensyn, ha en fin dag videre!";
    } else if (input=="Jeg elsker denne portalen!") {
        return "Det er godt å høre. Vi gjør hele tiden vårt ytterste for gi deg en best mulig opplevelse!"
    } else if (input == "Hjerte sendt!") {
        return "Det er fint å se. Vi gjør vårt beste for at nettopp du skal få en god opplevelse her på Nettkursportalen! :-)"
    } else if (input == "På gjensyn!") {
        return "Ha en fin dag videre!";
    } else {
        return "Jeg forstår ikke helt hva du mener... Gjerne spør om noe annet :-)";
    }

 
}