#include "solution.h"

int main() {
    vector<int> nums = {2, 7, 11, 15};
    int target = 9;
//    vector<int> nums = {3, 3};
//    int target = 6;
    auto solution = Solution();
    vector<int> result = solution.twoSum(nums, target);
    for (int x:result) {
        cout << x << endl;
    }
    return 0;
}
