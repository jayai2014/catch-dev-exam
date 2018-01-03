/* Todolist form validation and submission */
$(document).ready(function(){

    /* Load required elements */
    $inputGroup = $('#div-todo-text');
    $inputText = $('#todo-text-input');
    $form = $('#form-new-item');
    $btnSubmit = $('#button-submit');
    $labelWarning = $('#label-text-warning');
    $labelSubmitting =  $('#label-text-submitting');
    $msgNewItemSuccess = $('#form-msg-success');
    $msgNewItemError = $('#form-msg-error');
    $msgMarkError = $('#mark-error');
    $btnMarkComplete = $('.btn-mark-complete');

    $btnMarkComplete.click(function (e) {
        e.preventDefault();

        $url = $(this).attr('href');
        $id = $(this).attr('id');

        $.ajax({
            type: 'GET',
            url: $url,
            beforeSend: function() {
                displayMarkProgress($id);
                hideMarkResponseMsg();
            },
            dataType: "json",
            success: function (response) {
                if (response.success === true) {
                    //displayMarkResponseMsg(response.message);
                    location.reload();
                } else {
                    displayMarkResponseMsg(response.message, true);
                }
                hideItemSubmitProgress();
            },
            error: function (xhr, status, errorThrown) {
                displayMarkResponseMsg(errorThrown, true);
                hideMarkProgress($id);
            }
        });
    });

    $form.submit(function (e) {
        e.preventDefault();
        $url = $form.attr('action');
        $type = $form.attr('method');

        if (validateInput()) {
            // Only submit data if input has been validated.
            $.ajax({
                type: $type,
                url: $url,
                data: $form.serialize(),
                beforeSend: function() {
                    displayItemSubmitProgress();
                    hideNewItemResponseMsg();
                },
                dataType: "json",
                success: function (response) {
                    if (response.success === true) {
                        displayNewItemResponseMsg(response.message);
                        $inputText.val('');
                    } else {
                        displayNewItemResponseMsg(response.message, true);
                    }
                    hideItemSubmitProgress();
                },
                error: function (xhr, status, errorThrown) {
                    displayNewItemResponseMsg(errorThrown, true);
                    hideItemSubmitProgress();
                }
            });
        }
    });

    $inputText.on('input', function () {
        validateInput();
    });

    function validateInput() {
        if ($inputText.val().trim() === "") {
            $labelWarning.fadeIn();
            $inputGroup.addClass('has-error');
            return false;
        } else {
            $labelWarning.fadeOut();
            $inputGroup.removeClass('has-error');
            return true;
        }
    }

    function displayItemSubmitProgress() {
        $btnSubmit.prop('disabled', true);
        $inputText.prop('disabled', true);
        $labelSubmitting.fadeIn();
    }

    function hideItemSubmitProgress() {
        $btnSubmit.prop('disabled', false);
        $inputText.prop('disabled', false);
        $labelSubmitting.fadeOut();
    }

    function displayNewItemResponseMsg(message, error=false) {
        if (error) {
            $msgNewItemError.children(".text").text(message);
            $msgNewItemError.fadeIn();
        } else {
            $msgNewItemSuccess.children(".text").text(message);
            $msgNewItemSuccess.fadeIn();
        }
    }

    function hideNewItemResponseMsg() {
        $msgNewItemError.fadeOut();
        $msgNewItemSuccess.fadeOut();
    }

    function displayMarkProgress(id) {
        $('.btn-mark-complete').each(function () {
            $(this).addClass('disabled');
            if ($(this).attr('id') === id) {
                $(this).text('Processing...');
            }
        })
    }

    function hideMarkProgress(id) {
        $('.btn-mark-complete').each(function () {
            $(this).removeClass('disabled');
            if ($(this).attr('id') === id) {
                $(this).text('Mark as Complete');
            }
        })
    }

    function displayMarkResponseMsg(message, error=false) {
        if (error) {
            $msgMarkError.children(".text").text(message);
            $msgMarkError.fadeIn();
        }
    }

    function hideMarkResponseMsg() {
        $msgMarkError.fadeOut();
    }
});
