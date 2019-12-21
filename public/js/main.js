document.addEventListener('DOMContentLoaded', ()=>
{
    // console.log(document.querySelector('#close-regist-modal'));
    // console.log(document.querySelector('#register-modal'));
    //
    // document.querySelector('#open-register-form').addEventListener('click', () =>
    // {
    //     document.getElementById('register-modal').style.display = 'block';
    //     alert('TEST');
    // });

    //register modale instanciation
    let registModal = new Modal('#open-register-form', '#close-regist-modal', '#register-modal');
    console.log(registModal);

    //login modale instanciation
    let loginModal = new Modal('#open-login-form', '#close-login-modal', '#login-modal');
    console.log(loginModal);
});
