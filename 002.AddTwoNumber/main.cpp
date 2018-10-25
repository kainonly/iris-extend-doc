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
    ListNode l1 = ForWardListToListNode({2, 4, 3});
    ListNode l2 = ForWardListToListNode({5, 6, 4});
    ListNode p = l1;
    while (p.next) {
        cout << p.val << endl;
        p = *p.next;
    }


    return 0;
}