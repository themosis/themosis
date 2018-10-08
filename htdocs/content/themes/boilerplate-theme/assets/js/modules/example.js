export class Example {

	/**
	 * @param element
	 */
	constructor(element) {

		this.exampleElement = element;
		this.exampleElementChild = this.exampleElement.find('[data-js-example-element-child]');
	}

	/**
	 * Init
	 */
	init() {
		this.someFunctionality();
	}

	/**
	 * Initialise click events
	 */
	someFunctionality() {
		let _this = this;

		this.exampleElement.bind('click', function () {

			console.log(_this.exampleElement);
			console.log(this.exampleElement); // this wont work
		});
	}

}

export default Example;
