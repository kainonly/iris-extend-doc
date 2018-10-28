#ifndef LEETCODE_MAIN_H
#define LEETCODE_MAIN_H

#include <iostream>
#include <string>

using namespace std;

class Solution {
public:
    int lengthOfLongestSubstring(const string &s) {
        int size = s.size();
        if (size == 1) return 1;
        int max = 0, length = 0, alone = 0;
        for (int i = 0; i < size - 1; i++) {
            auto search = s.find_first_of(s[i], i + 1);
            if (search != string::npos) {
                length = search - i;
                alone = 0;
            } else alone = size - i;
            if (length > max) max = length;
        }
        if (alone && alone > max) max = alone;
        return max;
    }
};


#endif //LEETCODE_MAIN_H
