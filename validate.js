//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

/** 
 * @param {DOM Element} theForm The form being validated
 * @return {Boolean} true | false
*/

function validateForm(theForm) {
    var valid = true;

    //Checking if the search bar is empty
    if(!theForm.search.value.length) {
        //Highlighting and colouring and showing the error message as well the field if its empty
        valid = false;
        document.getElementById('search-error').style.display = "inline-block";
        theForm.search.style.border = "2px solid #ff0000";
        document.getElementById('search-label').style.color = '#ff0000';
    } else {
        //Hides the error message if the field is not empty and removes the error message
        document.getElementById('search-error').style.display = "none";
        theForm.search.style.border = "2px solid #ccc";
        document.getElementById('search-label').style.color = '#ffffff';
    }

    return valid;
}
