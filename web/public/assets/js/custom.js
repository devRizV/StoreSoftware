/**
 * Initializes Select2 for all elements with the 'product-name' class 
 * that are not already enhanced by Select2.
 */
function initializeProductNameSelect2() {
    // Iterate over each element with the 'product-name' class
    $('.product-name').each(function (index, element) {
        // Check if the element has not already been initialized by Select2
        if (!$(element).hasClass('select2-hidden-accessible')) {
            // Initialize Select2 on the element with specified options
            $(element).select2({
                width: '25rem', // Set the width of the Select2 dropdown
            });
        }
    });
}


/**
 * Dynamically handles the deletion of table rows when the delete button is clicked.
 */
function handleRowDeletion() {
    $(document).on('click', '.deleteRow', function (event) {
        event.preventDefault(); // Prevent default link or button behavior

        const userConfirmed = confirm("Do you want to delete this row?");
        if (userConfirmed) {
            const $deleteButton = $(this); // The clicked delete button
            const $row = $deleteButton.closest('tr'); // Get the associated table row
            $row.remove(); // Remove the row from the DOM

            $("#showMsg").text('Row was deleted successfully!').fadeOut(3000); // Show success message
            updateEntryCount(); // Update entry numbering or related logic
        } else {
            $("#showMsg").text('Row deletion was canceled.').show(); // Show cancellation message
        }
    });
}

/**
 * Checks if the value of a given input element is duplicated among other elements with the 'product-name' class.
 * 
 * @param {jQuery} $inputElement - The input element to check for duplicates.
 * @returns {boolean} - Returns true if a duplicate is found, false otherwise.
 */
function isDuplicateProductName($inputElement) {
    let isDuplicate = false;
    const inputValue = $inputElement.val();

    // Iterate over all other elements with the 'product-name' class
    $('.product-name').not($inputElement).each(function () {
        if ($(this).val() === inputValue) {
            isDuplicate = true;
            return false; // Exit the loop early if a duplicate is found
        }
    });

    return isDuplicate;
}


/**
 * Displays validation error messages for a specific input field, supporting both regular inputs and Select2 elements.
 * 
 * @param {string} field - The field name, optionally including an index (e.g., 'fieldName.0').
 * @param {Array} messages - An array of error messages, with the first message displayed.
 */
function displayFieldError(field, messages) {
    const [fieldName, index] = field.split('.'); // Split the field into name and index if applicable
    const selector = index !== undefined
        ? `[name="${fieldName}[]"]:eq(${index})` // Select indexed field (e.g., array-style inputs)
        : `[name="${fieldName}"]`; // Select single field
    if ($(selector).hasClass('select2-hidden-accessible')) {
        // If the field is a Select2 dropdown, style the container and add error message
        $(selector).next('.select2').addClass('is-invalid-select2');
        console.log($(selector).next('.select2'))
        $(selector).parent().append(`<small class='text-danger error-msg'>${messages[0]}</small>`);
    } else {
        // For regular inputs, add the error message and invalid styling
        $(selector).after(`<small class='text-danger error-msg'>${messages[0]}</small>`);
        $(selector).addClass('is-invalid');
    }
}


/**
 * Dynamically removes validation error messages and invalid styling 
 * from the specified input elements and their associated row.
 * 
 * @param {string} selector - A CSS selector for the input elements to monitor for changes.
 */
function clearErrorMessagesOnInput(selector) {
    $(document).on('input', selector, function () {
        const $row = $(this).closest('tr'); // Find the row containing the input element

        // Remove the 'is-invalid' class and associated error message for the current element
        $(this).removeClass('is-invalid')
            .next('.error-msg')
            .remove();

        // Remove 'is-invalid' class and error message for '.totalprice' within the same row
        $row.find('.totalprice').removeClass('is-invalid')
            .next('.error-msg')
            .remove();
    });
}


/**
 * Removes validation error messages and invalid styling from Select2 elements and their associated row on change.
 */
function clearSelectErrorMessages() {
    $(document).on('change', 'select', function () {
        const $selectElement = $(this); // The select element that triggered the change event
        const $row = $selectElement.closest('tr'); // Find the row containing the select element

        // Remove error styling and messages for the Select2 element
        $selectElement.next('.select2').removeClass('is-invalid-select2');
        $selectElement.parent().find('.error-msg').remove();

        // Remove error styling and messages for '.unit' within the same row
        $row.find('.unit').removeClass('is-invalid').next('.error-msg').remove();
    });
}


/**
 * Updates the entry count by calculating the number of rows in the product table 
 * and displaying the result in the entry count field.
 */
function updateEntryCount() {
    const entryCount = $('.product-table tbody tr').length - 1; // Count rows in the product table, excluding the header row
    $('#entryCount').text(entryCount); // Display the entry count in the #entryCount field
}

/**
 * Resets a form and its associated select2 elements.
 * 
 * @param {jQuery} $form - The form element (jQuery object) to reset.
 */
function resetFormAndSelect2($form) {
    // Reset form fields
    $form[0].reset();  // Reset the form fields to their initial values

    // Reset select2 elements
    $form.find('.select2-hidden-accessible').each(function () {
        const $select2 = $(this);
        $select2.val(null).trigger('change');  // Reset the select2 value
    });
}

/**
 * Calculates and updates the total price based on quantity and unit price, 
 * and triggers a price validation check whenever a quantity or price is modified.
 */
function updateTotalPrice() {
    let totalPrice = 0.00;

    $(document).on('keyup', '.quantity, .quantityprice', function () {
        const $inputElement = $(this); // The element that triggered the input event
        const $row = $inputElement.closest('tr'); // The row containing the input element
        const $unitPriceInput = $row.find('.quantityprice'); // The unit price input field
        const productId = $row.find('.product-name').val(); // The product ID

        if (productId) {
            const unitPrice = parseFloat($unitPriceInput.val()); // Parse the unit price
            const quantity = parseFloat($row.find('.quantity').val()); // Parse the quantity

            // Calculate the total price for the current row
            totalPrice = unitPrice * quantity || 0.000;
            $row.find('.totalprice').val(totalPrice.toFixed(3)); // Update the total price field

            if (unitPrice) {
                // Show processing message and perform price validation
                $unitPriceInput.next('.price-msg').remove();
                $unitPriceInput.after(`<small class='text-success price-msg'>processing..</small>`);

                validateProductPrice(unitPrice, productId, function (message, status) {
                    const textClass = status === "error" ? 'text-danger' : 'text-success';
                    $unitPriceInput.next('.price-msg').remove();
                    $unitPriceInput.after(`<small class='${textClass} price-msg'>${message}</small>`);
                });
            }
        } else {
            alert("Product name can't be empty!");
        }
    });
}


/**
 * Show session message after user interaction
 * @param {string} message the session message
 * @param {string} status request status (success, failed, null)
 * @param {css selector} messageElement the element that will show the message  
 */
function handleSessionMessage(message, status, messageElement) {
    let className = '';
    const msgContainer = `<button type="button" class="position-absolute top-0 end-0 me-2 mt-2 btn close-button">
                              <span class="fas fa-times"></span>
                            </button>
                            ${message}`;
    if (status === "success") {
        className = "alert alert-success";
    } else if (status === "failed") {
        className = "alert alert-danger";
    } else {
        className = "";
    }

    $(messageElement).empty()
        .removeClass('alert alert-success alert-danger')
        .addClass(className)
        .append(msgContainer);
    
    // Call remove session message function
    removeSessionMessage('.close-button');
}

// removes the session message and the classes

function removeSessionMessage(button) {
    $(document).on('click', button, function () {
        $(this).parent().empty()
            .removeClass('alert alert-success alert-danger');
    });
}