cmake_minimum_required(VERSION 3.12)
project(leetcode)

set(CMAKE_CXX_STANDARD 20)

add_executable(TwoSum 001.TwoSum/main.cpp 001.TwoSum/solution.h)
add_executable(AddTwoNumber 002.AddTwoNumber/main.cpp 002.AddTwoNumber/solution.h 004.MedianOfTwoSortedArrays/main.cpp)
add_executable(LongestSubstringWithoutRepeatingCharacters 003.LongestSubstringWithoutRepeatingCharacters/main.cpp 003.LongestSubstringWithoutRepeatingCharacters/solution.h)
add_executable(MedianOfTwoSortedArrays 004.MedianOfTwoSortedArrays/main.cpp 004.MedianOfTwoSortedArrays/solution.h)
add_executable(LongestPalindromicSubstring 005.LongestPalindromicSubstring/main.cpp 005.LongestPalindromicSubstring/solution.h)
add_executable(ZigzagConversion 006.ZigzagConversion/main.cpp 006.ZigzagConversion/solution.h)
add_executable(ReverseInteger 007.ReverseInteger/solution.h 007.ReverseInteger/main.cpp)
add_executable(StringToIntegerAtoi 008.StringToIntegerAtoi/main.cpp 008.StringToIntegerAtoi/solution.h)
add_executable(PalindromeNumber 009.PalindromeNumber/solution.h 009.PalindromeNumber/main.cpp)