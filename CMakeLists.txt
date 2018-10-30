cmake_minimum_required(VERSION 3.12)
project(leetcode)

set(CMAKE_CXX_STANDARD 20)

add_executable(TwoSum 001.TwoSum/main.cpp 001.TwoSum/solution.h)
add_executable(AddTwoNumber 002.AddTwoNumber/main.cpp 002.AddTwoNumber/solution.h 004.MedianOfTwoSortedArrays/main.cpp)
add_executable(LongestSubstringWithoutRepeatingCharacters 003.LongestSubstringWithoutRepeatingCharacters/main.cpp 003.LongestSubstringWithoutRepeatingCharacters/solution.h)
add_executable(MedianOfTwoSortedArrays 004.MedianOfTwoSortedArrays/main.cpp 004.MedianOfTwoSortedArrays/solution.h)
add_executable(LongestPalindromicSubstring 005.LongestPalindromicSubstring/main.cpp 005.LongestPalindromicSubstring/solution.h)
#add_executable(ZigzagConversion )
#add_executable(ReverseInteger )