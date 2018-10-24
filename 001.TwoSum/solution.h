#ifndef LEETCODE_SOLUTION_H
#define LEETCODE_SOLUTION_H

#include <iostream>
#include <vector>
#include <unordered_map>

using namespace std;

class Solution {
public:
    vector<int> twoSum(vector<int> &nums, int target) {
        vector<int> result;
        unordered_map<int, int> map = {};
        unordered_map<int, int> next = {};
        int len = nums.size();
        for (int i = 0; i < len; ++i) {
            int x = nums[i];
            auto search = map.find(x);
            if (search != map.end()) next.insert({x, i});
            else map.insert({x, i});
        }

        for (int i = 0; i < len; ++i) {
            int x = nums[i];
            int y = target - x;
            auto search_map = map.find(y);
            if (search_map != map.end() && map[y] != i) {
                result = {i, map[y]};
                break;
            } else {
                auto search_next = next.find(y);
                if (search_next == next.end()) continue;
                result = {i, next[y]};
            };
        }
        return result;
    }
};

#endif //LEETCODE_SOLUTION_H
