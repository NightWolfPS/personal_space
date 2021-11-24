const { app, BrowserWindow } = require('electron')
const path = require('path')
const mysql = require("mysql2")
const connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  database: "diarydb",
  password: ""
})

function createWindow () {
  const win = new BrowserWindow({
    width: 1280,
    height: 720,
    webPreferences: {
      preload: path.join(__dirname, 'preload.js')
    }
  })

  win.loadFile('index.php')
}

app.whenReady().then(() => {
  createWindow()
  app.on('activate', function () {
    if (BrowserWindow.getAllWindows().length === 0) createWindow()
  })
})

