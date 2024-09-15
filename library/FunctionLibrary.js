class FunctionLibrary {
    //Creates a form in the container of the specified ID
    static createForm(containerId) {
        const container = document.getElementById(containerId);
        if (!container) {
            throw new Error("Container not found");
        }

        const form = document.createElement('form');
        container.appendChild(form);
        return form;
    }

    //Create a submit button with ID
    static createSubmitButton(text='submit', id=''){
            const button = document.createElement('button');
            button.type = 'submit';
            button.textContent = text;
            button.id = id;
        return button;
    }

    //Creates and adds a form field to the specified element
    static addFormField(form, element) {
        if (form && element) {
            form.appendChild(element);
        } else {
            throw new Error("Form or element is not valid");
        }
    }

    //Creates a generic text input 
    static createTextInput(name, placeholder = '') {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = name;
        input.placeholder = placeholder;
        input.required = true;
        return input;
    }

    //Creates a drop down
    static createDropDown(name, options = []) {
        const select = document.createElement('select');
        select.name = name;

        options.forEach(optionValue => {
            const option = document.createElement('option');
            option.value = optionValue;
            option.textContent = optionValue;
            select.appendChild(option);
        });

        return select;
    }

    //Creates radial buttons
    static createRadialButtons(name, options = []) {
        const container = document.createElement('div');

        options.forEach(optionValue => {
            const label = document.createElement('label');
            const input = document.createElement('input');
            input.type = 'radio';
            input.name = name;
            input.value = optionValue;
            input.required = true;
            label.textContent = optionValue;
            label.appendChild(input);
            container.appendChild(label);
        });

        return container;
    }

    // Creates an email input
    static createEmailInput(name, placeholder = '') {
        const input = document.createElement('input');
        input.type = 'email';
        input.name = name;
        input.placeholder = placeholder;
        input.required = true;

        // JavaScript email verivication
        input.addEventListener('input', () => {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(input.value)) {
                input.setCustomValidity('Please enter a valid email address.');
            } else {
                input.setCustomValidity('');
            }
        });

        return input;
    }

    // Creates a phone number input
    static createPhoneNumberInput(name, placeholder = '') {
        const input = document.createElement('input');
        input.type = 'tel';
        input.name = name;
        input.placeholder = placeholder;
        input.required = true;

        // Javascript verification
        input.addEventListener('input', () => {
            const phonePattern = /^\+?[0-9\s-]{7,15}$/;
            if (!phonePattern.test(input.value)) {
                input.setCustomValidity('Please enter a valid phone number.');
            } else {
                input.setCustomValidity('');
            }
        });

        return input;
    }

    //Capitalizes the first letter of a string
    static capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }


    static formatPhoneNumber(number) {
        const cleaned = ('' + number).replace(/\D/g, ''); // Remove non-digit characters
        const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/); // Match 10 digits in groups of 3, 3, and 4
        if (match) {
            return `(${match[1]}) ${match[2]}-${match[3]}`;
        }
        return null;
    }

    static formatDate(input) {
        // Remove all non-digit characters
        let cleaned = input.replace(/\D/g, '');

        // Ensure the string has at least 8 digits (MMDDYYYY)
        if (cleaned.length < 8) {
            return 'Invalid date format';
        }

        // Extract the month, day, and year
        let month = cleaned.substring(0, 2);
        let day = cleaned.substring(2, 4);
        let year = cleaned.substring(4, 8);

        // Add a '0' in front of single-digit day/month if necessary
        if (month.length === 1) {
            month = '0' + month;
        }
        if (day.length === 1) {
            day = '0' + day;
        }

        // Format the date as MM/DD/YYYY
        return `${month}/${day}/${year}`;
    }

    // Static method to send form data
    static submitForm(formElement, endpoint, method = 'POST') {
        // Create a FormData object from the form element
        const formData = new FormData(formElement);
    
        // Return a promise for handling asynchronous behavior
        return fetch(endpoint, {
          method: method,
          body: formData,
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          AjaxHelper.showSuccessMessage('Form submitted successfully!', data);
        })
        .catch(error => {
          AjaxHelper.showErrorMessage('Error submitting form: ' + error.message);
        });
      }
    
      // Static method to display success messages
      static showSuccessMessage(message, data) {
        const successElement = document.createElement('div');
        successElement.className = 'success-message';
        successElement.textContent = `${message} - Response: ${JSON.stringify(data)}`;
        document.body.appendChild(successElement);
      }
    
      // Static method to display error messages
      static showErrorMessage(message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        document.body.appendChild(errorElement);
      }

      
}