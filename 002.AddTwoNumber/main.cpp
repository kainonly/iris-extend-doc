#include "solution.h"
#include <forward_list>


ListNode ForWardListToListNode(forward_list<int> list) {
    auto begin = list.begin();
    auto *l1 = (list.empty()) ? nullptr : new ListNode(*begin++);
    for (ListNode *x = l1; begin != list.end(); x = x->next) {
        x->next = new ListNode(*begin++);
    }
    return *l1;
}

int main() {
    // TEST 1
//    ListNode l1 = ForWardListToListNode({2, 4, 3});
//    ListNode l2 = ForWardListToListNode({5, 6, 4});
    // TEST 2
    ListNode l1 = ForWardListToListNode({5});
    ListNode l2 = ForWardListToListNode({5});
    ListNode *l = Solution().addTwoNumbers(&l1, &l2);
    cout << l->val << endl;
    cout << l->next->val << endl;
//        cout << l->next->next->val << endl;
    return 0;
}