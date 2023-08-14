import moment from "moment";

export const dateFormatter = (date) => {
    return moment(date).format("YYYY-MM-DD");
};

var keycodes = {
    backspace: 8,
    delete: 46,
    leftArrow: 37,
    rightArrow: 39,
    number1: 48,
    number9: 57,
};

export const justNumbers = (e) => {
    var charCode = e.which ? e.which :
                 (e.charCode ? e.charCode :
                   (e.keyCode ? e.keyCode : 0));

    if ((charCode < keycodes.number1 || charCode > keycodes.number9) &&
        charCode !== keycodes.delete &&
        charCode !== keycodes.backspace &&
        charCode !== keycodes.leftArrow &&
        charCode !== keycodes.rightArrow)
        e.preventDefault();
}

export const monetaryFormat = (x) => {
    x = (Math.round(x*100)/100).toFixed(2)
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
