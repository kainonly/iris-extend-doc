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
    auto p1 = &l1;
    auto p2 = &l2;
    ListNode last(0);
    auto *p = &last;
    while (p1 || p2) {
        int full = 0;
        int sum = p1->val + p2->val;
        if (sum > 9) {
            full = 1;
            sum = sum - 10;
        }

        p = new ListNode(sum);
        cout << p << endl;
        if (!p1->next && !p2->next) break;
        if (!p1->next) p1->next = new ListNode(0);
        p1 = p1->next;
        if (full) p1->val++;
        if (!p2->next) p2->next = new ListNode(0);
        p2 = p2->next;
        p = p->next;
    }

    cout << last.val << endl;
    cout << last.next->val << endl;
    cout << last.next->next->val << endl;
    return 0;
}