/*
 * Template management
 */
function Template() {
};

/*
 * Add template to pool
 */
Template.add = function(key, text) {
	// Check key null or empty
	if (!key) return;
	// Check key exists
	if (key in Template._text) {
		Template._function[key] = null;
	}
	// Add to list
	Template._text[key] = text;
}

/*
 * Return generated function which is created from template
 */
Template.get = function(key, data) {
	// Check key null or empty
	if (!key) return;
	// Check key exists
	if (!(key in Template._text)) return null;

	var generatedFunction = null;
	// Generate function from template if not generated yet
	if (!(key in Template._function) || ((generatedFunction = Template._function[key]) == null)) {
		generatedFunction = doT.template(Template._text[key]);
		// Cache result
		Template._function[key] = generatedFunction;
	}
	return generatedFunction(data);
}

Template._text = {};
Template._function = {};