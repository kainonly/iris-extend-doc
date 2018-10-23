#include "TwoSum_1.h"

int main() {
    set<int> nums = {2, 7, 11, 15};
    int target = 18;
    set<int> result = TwoSum(nums).Get(target);
    for (auto x:result) {
        cout << x << endl;
    }
}
