$(function(){

})

function popupNewFolder(){
    closePopup();
    $('.add-new-folder').addClass('show');
}

function popupNewNote(){
    closePopup();
    $('.add-new-note').addClass('show');
}

function popupNewProfile(){
    closePopup();
    $('.add-new-profile').addClass('show');
}

function closePopup(){
    $('.add-new-folder').removeClass('show');
    $('.add-new-note').removeClass('show');
    $('.add-new-profile').removeClass('show');
}