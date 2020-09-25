class ModalController{
    constructor(size = ''){
        this.size = size;
        this.modalName = 'modal-default';
        this.startConfig();
    }
    startConfig(){
        let modalDialog = $('#'+this.modalName+' .modal-dialog');
        modalDialog.removeClass('modal-sm modal-lg modal-fluid').addClass(this.size);
        $('#'+this.modalName+'modal-default-footer').find('button:not(.close-btn)').remove();
        let modalBody = $('#'+this.modalName+'-body');
        modalBody.empty();
        return this;
    }
    setModalName(name){
        this.modalName = name;
        this.startConfig();
        return this;
    }
    show(){
        $('#'+this.modalName+'-header').children().fadeOut();
        $('#'+this.modalName).modal();
        return this;
    }
    hide(){
        $('#'+this.modalName).modal('toggle');
        return this;
    }
    appendBody(content){'div'
        let modalBody = $('#'+this.modalName+'-body');
        modalBody.append(content);
        return this;
    }
    appendButton(content){
        let modalFooter = $('#'+this.modalName+'-footer');
        modalFooter.prepend(content);
        return this;
    }
    clearButtons(){
        $('#'+this.modalName+'-footer').find('button:not(.close-btn)').remove();
        return this;
    }
}
