import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    container;
    counter;
    newWidget;
    templateId;
    initItems;

    connect() 
    {
        // Recupération des noeud HTML dès le déclenchement du controller
        this.container = this.element;
        this.counter = this.container.dataset.itemCounter;
        this.templateId = this.container.dataset.templateId;
        this.initItems = this.container.dataset.initItems || 1;

        this.newWidget = this.container.querySelector(`[id=${this.templateId}]`);

        for (let i=0; i<this.initItems; i++) this.add();
    }

    add()
    {
        // Remplacement de la chaine "__name__"
        // "newWidget" est une Chaine de caractères
        let newWidget = this.newWidget.innerHTML.replace(/__name__/g, this.counter);

        // Incrémentation du compteur
        this.counter++;

        // Mise à jour du compteur
        this.container.dataset.itemCounter = this.counter;

        // Création d'un noeud HTML a partir de la chaine "newWidget"
        var parser = new DOMParser();
        var widget = parser.parseFromString(newWidget, 'text/html');

        // Ajout d'un attribut d'identification du noeud "widget"
        widget = widget.body
        widget.dataset.fieldSerial = this.counter-1;

        // Injection du noeud HTML dans le container de collection
        this.container.prepend( widget );
    }

    remove(event)
    {
        let btn = event.target

        // Recupération de l'ID de widget a supprimer
        let widgetId = btn.dataset.target

        // Cible le widget a supprimer
        let widget = this.container.querySelector(`[data-field-serial="${widgetId}"]`);

        // Suppression du widget
        widget.remove();
    }
}