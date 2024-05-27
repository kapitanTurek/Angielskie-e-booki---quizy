function getSupport(){
    let pageTitle = document.getElementById('sectionTitle');
    pageTitle.textContent = "Pomoc techniczna";

    let loginHolder = document.getElementById('wholeLogin');
    loginHolder.style.display = "none";

    let passwordHolder = document.getElementById('passwordHolder');
    passwordHolder.style.display = "none";

    let supportNote = document.getElementById("supportInformation");
    supportNote.style.display = "block";
    supportNote.textContent = "W celu zmiany hasła - skontaktuj się proszę z administratorem tej sekcji strony. Kontakt: Turek Marcin"

    let additionalNote = document.getElementById('restoration');
    additionalNote.textContent = "Jednak pamiętasz hasło? ";

    let interactionButton = document.createElement("a");
    interactionButton.href = "#";
    interactionButton.className = "loginLink";
    interactionButton.id = "interaction";
    interactionButton.setAttribute("onclick", "showSignIn()");
    interactionButton.textContent = "Wróć do logowania!";

    let submitButton = document.getElementById('submit');
    submitButton.style.display = "none";

    additionalNote.appendChild(interactionButton);
}

function showSignIn(){
    let pageTitle = document.getElementById('sectionTitle');
    pageTitle.textContent = "Zaloguj się!";

    let loginHolder = document.getElementById('wholeLogin');
    loginHolder.style.display = "block";

    let passwordHolder = document.getElementById('passwordHolder');
    passwordHolder.style.display = "block";

    let supportNote = document.getElementById("supportInformation");
    supportNote.style.display = "none";

    let additionalNote = document.getElementById('restoration');
    additionalNote.textContent = "Zapomniałeś hasła? ";

    let interactionButton = document.createElement("a");
    interactionButton.href = "#";
    interactionButton.className = "loginLink";
    interactionButton.id = "interaction";
    interactionButton.setAttribute("onclick", "getSupport()");
    interactionButton.textContent = "Uzyskaj pomoc!";

    let submitButton = document.getElementById('submit');
    submitButton.value = "Zaloguj się";
    submitButton.style.display = "block";

    additionalNote.appendChild(interactionButton);
}