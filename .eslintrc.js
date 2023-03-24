module.exports = {
  env: {
    jest: true,
    browser: true,
    node: true,
  },
  // Standard JavaScript Style Guide
  // extends: ["standard", "plugin:prettier/recommended"],
  // Airbnb JavaScript Style Guide
  extends: ['airbnb-base', 'plugin:prettier/recommended'],
  // Google JavaScript Style Guide
  // extends: ["google", "plugin:prettier/recommended"],

  rules: {
    'no-new': 0,
    'no-plusplus': 0,
    'func-names': 0,
    'no-undef': 0,
    'no-console': 0,
    'no-useless-return': 0,
    'import/no-unresolved': 0,
    'import/no-extraneous-dependencies': 0,
    'no-shadow': 0,
    'no-alert': 0,
    'no-param-reassign': 0,
    'no-unused-vars': 0,
    'no-cond-assign': 0,
    'no-restricted-syntax': 0,
    'prettier/prettier': [
      'error',
      {
        singleQuote: true,
        semi: false,
        parser: 'flow',
      },
    ],
  },
}
