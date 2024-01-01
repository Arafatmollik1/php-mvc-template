$(document).ready(function() {
    var inputCounter = 1; // Counter to track the number of inputs added

    $('#addNewAdult').click(function(event) {
        event.preventDefault();
        // Create the new input and label elements
        var newInput = $('<input>', {
            type: 'text',
            class: 'form-control',
            id: 'floatingNewInput' + inputCounter,
            name: 'newAdult' + inputCounter,
            placeholder: 'Password'
        });

        var newLabel = $('<label>', {
            for: 'floatingNewInput' + inputCounter,
            text: 'New Input'
        });

        // Wrap the input and label in a div with class form-floating
        var newInputDiv = $('<div>', {
            class: 'form-floating'
        }).append(newInput).append(newLabel);

        // Append the new div to inputDiv
        $('#inputDiv').append(newInputDiv);

        // Increment the counter for the next input
        inputCounter++;
    });
});