/**
 * @param {number[]} nums
 * @param {number} target
 * @return {number[]}
 */
var twoSum = function (nums, target) {
	let exist;
	const len = nums.length;

	for (let index = 0; index < len; index++) {
		const has = nums.indexOf(target - nums[index]);
		if (has !== -1 && has !== index) {
			exist = [index, has];
			break;
		}
	}

	return exist;
};

const nums = [3, 2, 4], target = 6;
const n = twoSum(nums, target);
console.log(n);