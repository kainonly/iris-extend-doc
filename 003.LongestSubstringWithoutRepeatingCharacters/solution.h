#ifndef LEETCODE_MAIN_H
#define LEETCODE_MAIN_H

#include <iostream>
#include <string>
#include <unordered_map>

using namespace std;

class Solution {
public:
    int lengthOfLongestSubstring(const string &s) {
        int size = s.size();
        if (size == 1) return 1;
        unordered_map<int, int> cons;
        for (int i = 0; i < size - 1; i++) {
            auto search = s.find_first_of(s[i], i + 1);
            if (search != string::npos) {
                int prev = cons[i - 1];
                if (prev >= search) cons[i - 1] = i;
                else cons.insert({i, search - 1});
            } else cons.insert({i, size - 1});
        }
        int max = 0;
        int len = cons.size();
        for (int i = 0; i < len; i++) {
            int length = cons[i] - i + 1;
            if (length > max) max = length;
        }
        return max;
    }
};


#endif //LEETCODE_MAIN_H
