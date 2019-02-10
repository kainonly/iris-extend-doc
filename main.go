package main

import (
	"github.com/kataras/iris"
	"github.com/kataras/iris/mvc"
	"kainonly/redis-manager-server/src/controller"
)

func main() {
	app := iris.New()
	router := mvc.New(app)
	router.Handle(new(controller.StringType))

	if err := app.Run(iris.Addr(":3000")); err != nil {
		panic("failed to start server")
	}
}
