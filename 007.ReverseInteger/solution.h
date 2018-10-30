#ifndef LEETCODE_SOLUTION_H
#define LEETCODE_SOLUTION_H

#include <iostream>

using namespace std;

class Solution {
public:
    int reverse(int x) {
        int result = 0;
        while (x != 0) {
            int last = x % 10;
            x = (x - last) / 10;
            if (result > INT_MAX / 10 || (result == INT_MAX / 10 && last > 7)) return 0;
            if (result < INT_MIN / 10 || (result == INT_MIN / 10 && last < -8)) return 0;
            result = result * 10 + last;
        }
        return result;
    }
};

#endif //LEETCODE_SOLUTION_H
