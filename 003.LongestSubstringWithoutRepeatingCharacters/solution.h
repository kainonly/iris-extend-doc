#ifndef LEETCODE_MAIN_H
#define LEETCODE_MAIN_H

#include <iostream>
#include <string>

using namespace std;

class Solution {
public:
    int lengthOfLongestSubstring(const string &s) {
        int size = s.size();
        int max = 0, length = 0;
        bool repeat = false;
        for (int i = 0; i < size; i++) {
            auto search = s.find_first_of(s[i], i + 1);
            if (search != string::npos) {
                length = search - i;
                repeat = true;
            }
            if (length > max)max = length;
        }
        if (!repeat) max = size;
        return max;
    }
};


#endif //LEETCODE_MAIN_H
