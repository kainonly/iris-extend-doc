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
            result = result * 10 + last;
        }
        return result;
    }
};

#endif //LEETCODE_SOLUTION_H
