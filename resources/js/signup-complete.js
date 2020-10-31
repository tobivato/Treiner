let leadform = document.querySelector('#leadform');
if (leadform) {
    leadform.addEventListener("submit", function(e) {
        e.preventDefault();
        window.location = "mailto:" + document.querySelector('#email').value + 
        "?subject=Interested%20in%20joining%20Treiner%3F&body="
         + encodeURIComponent('Hi ' + document.querySelector('#name').value + 
         ',\n Are you interested in using Treiner to improve your coaching experience? Check out Treiner (https://treiner.co), an online system that will allow you to more effectively manage your sessions and gain new players.');
    });
}

let coachLeadform = document.querySelector('#coach-leadform');
if (coachLeadform) {
    coachLeadform.addEventListener("submit", function(e) {
        e.preventDefault();
        let emails = document.getElementsByClassName("email");
        let mailtoString = "mailto:";
        for (let i = 0; i < emails.length; i++) {
            const email = emails[i].value;
            mailtoString += email + ',';
        }   
        mailtoString += '?subject=' + encodeURIComponent("Hey, I've just joined Treiner") 
                     + "&body=" + encodeURIComponent(
                        "Hi players, just letting you know that I've joined Treiner (https://treiner.co). Treiner is an online platform that allows players to book and manage their soccer coaching sessions. You can check out my profile here: " + document.querySelector('#coach-link').value
        );

        window.location = mailtoString;             
    });
}

let addPlayer = document.querySelector('#add-player');
if (addPlayer) {
    addPlayer.addEventListener("click", function(e) {
        e.preventDefault();
        document.querySelector('#players').insertAdjacentHTML('beforeend',
            `
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="email" name="email" required class="form-control email" placeholder="Add the player's email address">
                    </div>
                </div>
            </div>
            `
        );
    });
}