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
 * Fetches and populates the product unit for the selected product, 
 * and prevents duplicate product names from being entered.
 * 
 * @param {string} fetchUnitUrl - the route for fetching the product's unit
 */
function fetchAndPopulateProductUnit(fetchUnitUrl) {
    $(document).on('change', '.product-name', function (e) {
        e.preventDefault();

        const $productSelect = $(this); // The product name select element
        const productId = $productSelect.val(); // The selected product ID
        let $row, $unitInput;

        if ($productSelect.closest('tr').length) {
            $row = $productSelect.closest('tr');
            $unitInput = $row.find('.unit');
        } else {
            $unitInput = $('.unit');
        }

        // Check if the product name has already been entered
        if (isDuplicateProductName($productSelect)) {
            if ($productSelect.hasClass('select2-hidden-accessible')) {
                // Clear the select and display an error message if duplicate
                $productSelect.val(null).trigger('change')
                    .after(`<small class="text-danger error-msg">Product name already entered!</small>`);
            }
        } else {
            // Fetch the product unit if no duplicate product is found
            $.ajax({
                type: "GET",
                url: fetchUnitUrl,
                data: { 
                    nameid: productId,
                },
                dataType: "json",
                success: function (response) {
                    // Populate the unit field in the row with the retrieved unit
                    $unitInput.val(response.unit);
                },
                error: function () {
                    console.error('Error fetching product unit.');
                }
            });
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
 * and triggers a debounced price validation check whenever a quantity or price is modified.
 */
function updateTotalPrice() {

    let debounceTimeout;

    $(document).on('keyup', '.quantity, .quantityprice', function () {
        const $inputElement = $(this); // The element that triggered the input event
        let $row, $unitPriceInput, productId, $quantityInput, $totalPriceInput

        // if multi entry form check if the inputs are in a table
        if ($inputElement.closest('tr').length) {
            $row = $inputElement.closest('tr'); // The row containing the input element
            $unitPriceInput = $row.find('.quantityprice'); // The unit price input field
            $quantityInput = $row.find('.quantity'); // quantityprice input field
            $totalPriceInput = $row.find('.totalprice'); // Total price field in the table
            productId = $row.find('.product-name').val(); // The product ID
        } else {
            $unitPriceInput = $('.quantityprice'); // The unit price input field
            $quantityInput = $('.quantity'); // The quantityprice input field
            $totalPriceInput = $('.totalprice'); // Total price field
            productId = $('.product-name').val(); // The product ID
        }

        if (productId) {
            const unitPrice = parseFloat($unitPriceInput.val()); // Parse the unit price
            const quantity = parseFloat($quantityInput.val()); // Parse the quantity

            // Calculate the total price for the current row
            const totalPrice = unitPrice * quantity || 0.000;
            $totalPriceInput.val(totalPrice.toFixed(3)); // Update the total price field

            if (unitPrice) {
                // Show processing message and perform price validation
                $unitPriceInput.next('.price-msg').remove();
                $unitPriceInput.after(`<small class='text-success price-msg'>processing..</small>`);

                // clear the previous timeout and debounce the price validation
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    validateProductPrice(
                        unitPrice, 
                        productId, 
                        function (message, status) {
                        const textClass = status === "error" ? 'text-danger' : 'text-success';
                        $unitPriceInput.next('.price-msg').remove();
                        $unitPriceInput.after(`<small class='${textClass} price-msg'>${message}</small>`);
                    });
                }, 500); // delay set to 500ms (0.5sec)
            }
        } else {
            alert("Product name can't be empty!");
        }
    });
}

/**
 * Compares the previously stored price with the currently entered price 
 * and calls a callback with the appropriate message and status.
 * 
 * @param {number} currentPrice - The price currently entered by the user.
 * @param {number} productId - The ID of the product to check.
 * @param {function} callback - A function to be called with the comparison result.
*/
function validateProductPrice(currentPrice, productId, callback) {
    $.ajax({
        type: "GET",
        url: '/get-product-price',
        data: { 
            prdprice: currentPrice, 
            productId: productId,
        },
        dataType: "json",
        success: function (response) {
            // Pass the comparison result and status to the callback
            callback(response.message, response.status);
        },
        error: function (xhr, status, error) {
            // Log the error and pass an error message to the callback
            console.error('AJAX error:', error);
            callback(xhr.responseJSON.error, status);
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
    } else if (status === "error") {
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

/**
 * Function initializes the purchase products list as a DataTable with server-side processing with dynamic URL
 * 
 * @param {string} tableSelector - The CSS selector for the table element
 * @param {string} url - The dynamic URL for fetching neccessary data.
 * @param {Array} tableOrder - The order of the data based on the columns: format - [columnIndex, orderDirection] - e.g. : [0, 'asc']
 * 
 * @returns {Object}
 */
function initializePurchaseDataTable(tableSelector, url, tableOrder = [0, 'desc']) {
    const table = $(tableSelector).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: 'GET',
            dataSrc: function (response) {
                const totalPriceContainer = $(`${tableSelector} tfoot th:nth-child(1)`);
                const loadedTotalPriceContainer = $(`${tableSelector} tfoot th:nth-child(2)`);

                if (totalPriceContainer) {
                    totalPriceContainer.html(`Total: ${response.totalPriceSum.toFixed(3)}`);
                }
                if (loadedTotalPriceContainer) {
                    loadedTotalPriceContainer.html(`Current page total: ${response.loadedTotalPriceSum}`);
                }

                return response.data;
            },
        },
        columns: [
            { data: 'sl', title: 'SL' }, // SL
            { data: 'prd_name', title: 'Name' }, // Name
            { data: 'prd_req_dep', title: 'Req. Dept.' }, // Req. Dept.
            { data: 'prd_qty', title: 'Quantity' }, // Quantity.
            { data: 'prd_unit', title: 'Unit' }, // Unit
            { data: 'prd_qty_price', title: 'Purchase Date' }, // Purchase price
            { data: 'prd_price', title: 'Total Price' }, // Total Price
            { data: 'prd_grand_price', title: 'G. Total Price' }, // G. Total Price
            { 
                data: 'prd_purchase_date', 
                Title: 'Purchase Date',
                render: function (data, type, row) {
                    if (data) {
                        return formatUserFriendlyDate(data);
                    }
                    return ""; // if no data, return empty
                }
            }, // Purchase Date
            { 
                data: 'created_at', 
                title: "Created",
                render: function (data, type, row) {
                    if (data) {
                        return formatUserFriendlyDate(data);
                    }
                    return ""; // if no data, return empty
                }
             }, // Created
            { data: 'stock', title: 'Stock' }, // Stock
            {
                data: 'pk_no',
                title: 'Action',
                render: function (data, type, row) {
                    return `
                <a class="btn btn-primary btn-xs edit-btn" data-id="${data}"> 
                  <i class="fa fa-edit"></i>
                  </a>
                <a class="btn btn-primary btn-xs view-btn" data-id="${data}"> 
                  <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-danger btn-xs delete-btn" data-id=${data}> 
                  <i class="fa fa-trash"></i>
                </a>
              `;
                },
                orderable: false,
            }, // Action
        ],
        order: [tableOrder], // Default sorting (by SL)
    });

    return table;
}


/**
 * Function to handle the viewing of items via AJAX.
 * 
 * @param {string} viewUrl - The URL to send the view page request to. It should include the product ID or resource identifier.
 * @param {function} onSuccess - Callback function to execute on successful view page retrieval. The response object is passed to this function.
 * @param {function} onError - Callback function to execute if an error occurs during view page retrieval. The error details are passed to this function.
 */
function viewProduct(viewUrl, onSuccess, onError) {
    $.ajax({
        type: "GET",
        url: viewUrl,
        dataType: "html",
        success: function (response) {
            onSuccess(response);
        },
        error: function (xhr, status, error) {
            onError(xhr, status, error);
        }
    });
}

/**
 * Function to handle the call for edit form via 
 * server side rendering using AJAX request.
 * 
 * @param {string} editUrl - The URL to send the edit page request to. It should include the product ID or resource identifier.
 * @param {function} onSuccess - Callback function to execute on successful page and data retrieval. The response object is passed to this function.
 * @param {function} onError - Callback function to execute if an error occurs during page and data retrieval. The error details are passed to this function.
 */
function editProduct(editUrl, onSuccess, onError) {
    $.ajax({
        type: "GET",
        url: editUrl,
        dataType: "json",
        success: function (response) {
            onSuccess(response);
        },
        error: function (xhr, status, error) {
            onError(xhr, status, error);
        }
    });
}

/**
 * Function to handle the deletion of items via AJAX with confirmation.
 * 
 * @param {string} deleteUrl - The URL to send the DELETE request to. It should include the product ID or resource identifier.
 * @param {function} onSuccess - Callback function to execute on successful deletion. The response object is passed to this function.
 * @param {function} onError - Callback function to execute if an error occurs during deletion. The error details are passed to this function.
 */
function handleDelete(deleteUrl, onSuccess, onError) {
    // Confirm deletion with the user
    if (confirm("Are you sure you want to delete this item?")) {
        // Send an AJAX DELETE request
        $.ajax({
            type: "POST", // Method for Laravel CSRF compatibility (can also use DELETE if configured)
            url: deleteUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel security
            },
            success: function (response) {
                // Execute the onSuccess callback with the response
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            },
            error: function (xhr, status, error) {
                // Execute the onError callback with the error details
                if (typeof onError === 'function') {
                    onError(xhr, status, error);
                }
            }
        });
    }
}

/**
 * Formats a given date string into a user-friendly display format.
 * 
 * - Displays a short date format (e.g., "05-Jan-2025") for quick readability.
 * - Shows a full date with time (e.g., "05/01/2025, 1:30:45 PM") as a tooltip for more detailed information.
 *
 * @param {string} date - The input date string to be formatted.
 * @returns {string} - An HTML string with the short date as the visible text and the full date in the title attribute.
 */
function formatUserFriendlyDate(date) {
    const dateObj = new Date(date);

    // Format for quick display: e.g., "05-Jan-2025"
    const shortDate = dateObj.toLocaleDateString('en-GB', {
        day: "2-digit",
        month: 'short',
        year: "numeric"
    });

    // Format for detailed display (tooltip): e.g., "05/01/2025, 1:30:45 PM"
    const detailedDate = dateObj.toLocaleDateString('en-GB', {
        day: "2-digit",
        month: 'short',
        year: "numeric",
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    // Return the formatted HTML with tooltip
    return `<span title="${detailedDate}">${shortDate}</span>`;
}
