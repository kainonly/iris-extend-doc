#ifndef LEETCODE_TWOSUM_H
#define LEETCODE_TWOSUM_H

#include <iostream>
#include <set>

using namespace std;

class TwoSum {
public:
    explicit TwoSum(set<int> &nums) {
        this->numbers = nums;
    }

    set<int> Get(int target) {
        set<int> sum;
        for (auto x:this->numbers) {
            int y = this->match(target - x);
            if (y == 0) continue;
            else {
                sum.insert(x);
                sum.insert(y);
                break;
            }
        }
        return sum;
    }

private:
    set<int> numbers;

    int match(int num) {
        auto search = this->numbers.find(num);
        if (search != this->numbers.end()) {
            return *search;
        } else {
            return 0;
        }
    }
};


#endif //LEETCODE_TWOSUM_H
