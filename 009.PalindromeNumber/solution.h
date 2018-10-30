#ifndef LEETCODE_SOLUTION_H
#define LEETCODE_SOLUTION_H

#include <iostream>

using namespace std;

class Solution {
public:
    bool isPalindrome(int x) {
        if (x < 0) return false;
        int result = 0;
        while (x != 0) {
            int last = x % 10;
            x = (x - last) / 10;
            if (result > INT_MAX / 10 || (result == INT_MAX / 10 && last > 7)) return false;
            result = result * 10 + last;
        }
        return x == result;
    }
};

#endif //LEETCODE_SOLUTION_H
