export default class InputFormatter {

    removeComma(value) {
        let amount = 0;
        if(value) {
            amount = value.split(',').join("")
        }

        return amount
    }

}
