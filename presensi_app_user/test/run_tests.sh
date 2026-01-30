#!/bin/bash

# Test Runner Script untuk Presensi App User
# Usage: ./run_tests.sh [option]

set -e

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Presensi App User - Test Runner     ${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Function to run all tests
run_all_tests() {
    echo -e "${YELLOW}Running all tests...${NC}"
    flutter test -r expanded
}

# Function to run specific test
run_specific_test() {
    echo -e "${YELLOW}Running $1...${NC}"
    flutter test test/$1 -r expanded
}

# Function to run with coverage
run_coverage() {
    echo -e "${YELLOW}Running tests with coverage...${NC}"
    flutter test --coverage
    if [ -f "coverage/lcov.info" ]; then
        echo -e "${GREEN}✓ Coverage report generated: coverage/lcov.info${NC}"
    fi
}

# Function to show test summary
show_summary() {
    echo -e "${BLUE}Test Summary:${NC}"
    echo -e "${GREEN}✓ Widget Tests: 5 tests${NC}"
    echo -e "${GREEN}✓ Model Tests: 8 tests${NC}"
    echo -e "${GREEN}✓ Controller Tests: 9 tests${NC}"
    echo -e "${GREEN}✓ Utility Tests: 19 tests${NC}"
    echo -e "${BLUE}Total: 41 tests${NC}"
}

# Parse command line arguments
case "$1" in
    "all")
        run_all_tests
        ;;
    "widget")
        run_specific_test "widget_test.dart"
        ;;
    "model")
        run_specific_test "model_test.dart"
        ;;
    "controller")
        run_specific_test "controller_test.dart"
        ;;
    "utility")
        run_specific_test "utility_test.dart"
        ;;
    "coverage")
        run_coverage
        ;;
    "summary")
        show_summary
        ;;
    "help"|"--help"|"-h")
        echo "Usage: ./run_tests.sh [option]"
        echo ""
        echo "Options:"
        echo "  all         - Run all tests"
        echo "  widget      - Run widget tests only"
        echo "  model       - Run model tests only"
        echo "  controller  - Run controller tests only"
        echo "  utility     - Run utility tests only"
        echo "  coverage    - Run tests with coverage"
        echo "  summary     - Show test summary"
        echo "  help        - Show this help message"
        echo ""
        ;;
    *)
        echo -e "${YELLOW}No option specified. Running all tests...${NC}"
        echo -e "${YELLOW}Use './run_tests.sh help' for options${NC}"
        echo ""
        run_all_tests
        ;;
esac

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}   Test execution completed!           ${NC}"
echo -e "${GREEN}========================================${NC}"

