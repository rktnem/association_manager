import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        // Get child element length for indexing
        this.index = this.element.childNodes.length;
        // Add index label for good ux
        this.intiFieldset();
    }

    intiFieldset() {
        // Create add details button
        this.addButtonElement();
        // Add index label for good ux
        this.fieldsetComponent();
    }

    fieldsetComponent() {
        this.element.childNodes.forEach((fieldset, index) => {
            if (index == this.element.childNodes.length - 1) {
                return;
            }
            this.#createLabel(fieldset, index);
            this.#createDeleteButton(fieldset);
        });
    }

    #createLabel(fieldset, index) {
        const labelElement = document.createElement("span");
        labelElement.textContent = index + 1;
        labelElement.classList.add("field-index");

        fieldset.insertBefore(labelElement, fieldset.firstChild);
    }

    #createDeleteButton(fieldset) {
        const deleteButton = document.createElement("span");
        deleteButton.classList.add("field-delete");
        deleteButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26">
            <path d="M21.734375 19.640625L19.636719 21.734375C19.253906 22.121094 18.628906 22.121094 18.242188 21.734375L13 16.496094L7.761719 21.734375C7.375 22.121094 6.746094 22.121094 6.363281 21.734375L4.265625 19.640625C3.878906 19.253906 3.878906 18.628906 4.265625 18.242188L9.503906 13L4.265625 7.761719C3.882813 7.371094 3.882813 6.742188 4.265625 6.363281L6.363281 4.265625C6.746094 3.878906 7.375 3.878906 7.761719 4.265625L13 9.507813L18.242188 4.265625C18.628906 3.878906 19.257813 3.878906 19.636719 4.265625L21.734375 6.359375C22.121094 6.746094 22.121094 7.375 21.738281 7.761719L16.496094 13L21.734375 18.242188C22.121094 18.628906 22.121094 19.253906 21.734375 19.640625Z" fill="currentColor" />
        </svg>`;
        deleteButton.addEventListener("click", () => {
            this.deleteField(fieldset);
        });

        fieldset.appendChild(deleteButton);
    }

    addButtonElement() {
        const button = document.createElement("button");
        button.textContent = "Ajouter détails";
        button.classList.add("btn", "btn-sm");
        button.setAttribute("type", "button");
        // Attach create field method
        button.addEventListener("click", (e) => {
            this.createField(e);
        });

        this.element.appendChild(button);
    }

    createField(e) {
        const element = document
            .createRange()
            .createContextualFragment(
                this.element.dataset["prototype"].replaceAll(
                    "__name__",
                    this.index,
                ),
            ).firstElementChild;

        e.currentTarget.insertAdjacentElement("beforebegin", element);

        // Create label and delete button for the new fieldset
        this.#createLabel(element, this.index);
        this.#createDeleteButton(element);

        // Increment index
        this.index++;
    }

    deleteField(fieldset) {
        fieldset.remove();

        // Decrement index
        this.index--;
    }
}
