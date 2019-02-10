package controller

import (
	"github.com/kataras/iris"
)

type StringType struct {
}

func (c *StringType) PostSet() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostGet() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostGetRange() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostGetSet() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostMGet() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostSetBit() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostSetEx() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostSetNx() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostSetRange() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostMSet() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostMSetNx() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostPSetEx() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostIncr() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostIncrBy() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostIncrByFloat() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostDecr() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostDecrBy() iris.Map {
	return iris.Map{"error": 0}
}

func (c *StringType) PostAppEnd() iris.Map {
	return iris.Map{"error": 0}
}
