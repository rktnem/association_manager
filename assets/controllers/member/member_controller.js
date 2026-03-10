import { Controller } from "@hotwired/stimulus";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ["addLayout"];

    connect() {
        this.containerWidth = this.element.offsetWidth;
        this.formDisplay = false;

        this.definePosition(`${this.containerWidth * -1}px`);
    }

    display() {
        this.formDisplay = !this.formDisplay;

        this.formDisplay
            ? this.definePosition(0)
            : this.definePosition(`${this.containerWidth * -1}px`);

        console.log(`it works : ${this.formDisplay}`);
    }

    definePosition(position) {
        this.addLayoutTarget.style.right = position;
    }
}
