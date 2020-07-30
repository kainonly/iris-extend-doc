import { app, BrowserWindow } from 'electron';
import './ipc';

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
