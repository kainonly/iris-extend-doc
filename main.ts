import { app, BrowserWindow, ipcMain } from 'electron';
import * as Redis from 'ioredis';

const instance: { [id: string]: Redis.Redis } = {};

function createWindow() {
  const mainWindow = new BrowserWindow({
    height: 640,
    width: 960,
    minHeight: 640,
    minWidth: 960,
    autoHideMenuBar: true,
    titleBarStyle: 'hiddenInset',
    webPreferences: {
      nodeIntegration: true,
      enableRemoteModule: true
    }
  });
  mainWindow.loadURL('http://localhost:4200');
}

app.on('ready', () => {
  createWindow();
  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createWindow();
    }
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

ipcMain.on('redis:create', (event, args) => {
  if (!instance.hasOwnProperty(args.id)) {
    instance[args.id] = new Redis(args.options);
  }
});

ipcMain.on('redis:scan', (event, args) => {
  if (!instance.hasOwnProperty(args.id)) {
    event.returnValue = {
      error: 1,
      msg: 'Instance does not exist'
    };
    return;
  }
  const redis = instance[args.id];
  const stream = redis.scanStream();
  const keys: any[] = [];
  stream.once('data', (resultKeys) => {
    for (const key of resultKeys) {
      keys.push(key);
    }
  });
  stream.once('end', async () => {
    const data: any[] = [];
    while (keys.length !== 0) {
      const key = keys.pop();
      const type: string = await redis.type(key);
      data.push({
        key,
        type: type.toLocaleUpperCase()
      });
    }
    event.returnValue = {
      error: 0,
      data
    };
    stream.destroy();
  });
});

ipcMain.on('redis:destory', ((event, args) => {
  if (instance.hasOwnProperty(args.id)) {
    instance[args.id].disconnect();
    delete instance[args.id];
  }
}));

