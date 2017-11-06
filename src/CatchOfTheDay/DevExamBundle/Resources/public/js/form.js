/* Todolist form validation and submission */
$(document).ready(function(){
    $('#form-new-item').onsubmit(function () {
        if ($('#todo-text-input').text() === "") {
            $('#div-todo-text').addClass('has-error');
        } else {
            $('#div-todo-text').removeClass('has-error');
        }
    });
});
