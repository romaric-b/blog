class Modal
{
    constructor(openBtnSelector,closeBtnSelector, modalSelector)
    {
        this.openBtn = document.querySelector(openBtnSelector);
        this.closeBtn = document.querySelector(closeBtnSelector);
        this.modal = document.querySelector(modalSelector);
        console.log(this.openBtn); //ok
        console.log(this.closeBtn); //null
        console.log(this.modal); //null
        this.openModal();
        this.closeModal();
    }

    openModal()
    {
        var self = this;
        this.openBtn.addEventListener('click', () =>
        {
            self.modal.style.display = block;
            self.modal.style.opacity = 1;
        });
    }

    closeModal()
    {
        var self = this;
        this.closeBtn.addEventListener('click', () =>
        {
            self.modal.style.display = none;
        });
    }
}