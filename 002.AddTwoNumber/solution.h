#ifndef LEETCODE_SOLUTION_H
#define LEETCODE_SOLUTION_H

#include <iostream>

using namespace std;

struct ListNode {
    int val;
    ListNode *next;

    explicit ListNode(int x) : val(x), next(nullptr) {}
};

class Solution {
public:
    ListNode *addTwoNumbers(ListNode *l1, ListNode *l2) {
        auto *result = new ListNode(0);
        ListNode *p = result,
                *p1 = l1,
                *p2 = l2;
        int carry = 0;
        while (p1 || p2) {
            int sum = p1->val + p2->val + carry;
            carry = 0;
            if (sum > 9) {
                carry = 1;
                sum = sum - 10;
            }
            p->val = sum;
            if (!p1->next && !p2->next && !carry) break;
            if (!p1->next) p1->next = new ListNode(0);
            p1 = p1->next;
            if (!p2->next) p2->next = new ListNode(0);
            p2 = p2->next;
            p->next = new ListNode(0);
            p = p->next;
        }
        return result;
    }
};

#endif //LEETCODE_SOLUTION_H
