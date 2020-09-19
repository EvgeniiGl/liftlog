module.exports = {
    // The root of your source code, typically /src
    // `<rootDir>` is a token Jest substitutes
    roots: ["<rootDir>/resources/js/"],

    // Jest transformations -- this adds support for TypeScript
    // using ts-jest
    transform: {
        "(.*).(ts|tsx)$": "ts-jest"
    },

    // Runs special logic, such as cleaning up components
    // when using React Testing Library and adds special
    // extended assertions to Jest
    setupFilesAfterEnv: [
        "@testing-library/jest-dom/extend-expect"
    ],

    // Test spec file resolution pattern
    // Matches parent folder `__tests__` and filename
    // should contain `test` or `spec`.
    preset: "ts-jest",
    testRegex: "(/__tests__/.*|(\\.|/)(test|spec))\\.tsx?$",

    moduleNameMapper: {
        "@core/(.*)": "<rootDir>/resources/js/react/core/$1",
        "@react/(.*)": "<rootDir>/resources/js/react/$1"
    },
    // Module file extensions for importing
    moduleFileExtensions: ["ts", "tsx", "js", "jsx", "json", "node"],
    transformIgnorePatterns: [
        "<rootDir>/node_modules/(?!@foo)"
    ]
};
