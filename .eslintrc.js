module.exports = {
	env: {
		browser: true,
		commonjs: true,
		es6: true,
		node: true,
		jquery: true
	},
	extends: ["prettier"],
	rules: {
		"arrow-parens": [2, "as-needed"],
		"quote-props": [2, "consistent"],
		// "semi": [2, "never"],
		"quotes": [2, "double"],
		"comma-dangle": [2, "never"],
		"array-bracket-spacing": [2, "never"]
	},
	parserOptions: {
		sourceType: "module",
		ecmaVersion: 9
	}
};
