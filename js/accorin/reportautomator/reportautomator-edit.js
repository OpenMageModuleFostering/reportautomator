/**
 * Created by marcosegura on 10/21/15.
 */

varienGlobalEvents.attachEventHandler('formSubmit', function (arg) {
    $('template_hidden').value = editor.getText();
});
