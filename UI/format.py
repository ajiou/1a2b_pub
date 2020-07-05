import tkinter as tk
from tkinter import Listbox
from tkinter import END
import random
import re
import pymysql
import hashlib
import base64
import time

num = 0
player = ""
userID = ""
s = 0.0
list4 = []
tl = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())
db = pymysql.connect("database ip", "project", "密碼", "abgame")  # 連接伺服器
cursor = db.cursor()  # 連接伺服器


def vistoren():
    btnv.place_forget()
    btnlogin.place_forget()
    ab.pack()
    btn.pack()
    en.pack()
    roll.pack()
    enaccounts.place_forget()
    enpassword.place_forget()
    IDtxt.place_forget()
    passwordtxt.place_forget()
    errorla.place_forget()
    roll.delete(0, END)
    abtxt.set("按下按鈕開始")
    main.unbind('<Return>')
    main.bind('<Return>', entetpress)

def login(event):
    global userID, player, db, cursor
    
    roll.delete(0, END)
    abtxt.set("按下按鈕開始")
    userID = enid.get()
    userID = base64.b64encode(userID.encode("UTF-8")).decode("UTF-8")
    userps = enps.get()
    userps = base64.b64encode(userps.encode("UTF-8")).decode("UTF-8") + "加密鹽值"  # 密碼加密
    sha512 = hashlib.sha512()  # 密碼加密
    sha512.update(userps.encode('utf-8'))  # 密碼加密
    res = sha512.hexdigest()  # res = 加密後的密碼

    select = "SELECT * FROM account Where name = %(f)s"
    cursor.execute(select, {'f': userID})
    data = cursor.fetchone()
    if data is None:
        errortxt.set("無此帳號")
        errorla.place(x=280, y=150)
        return 0

    select = "SELECT * FROM account Where name = %(f)s"
    cursor.execute(select, {'f': userID})  # 查詢ID
    data = cursor.fetchone()  # 獲取ID密碼
    if res == data[2]:
        main.unbind('<Return>')
        main.bind('<Return>', entetpress)
        player = ""
        btnv.place_forget()
        btnlogin.place_forget()
        ab.pack()
        btn.pack()
        en.pack()
        roll.pack()
        enaccounts.place_forget()
        enpassword.place_forget()
        IDtxt.place_forget()
        passwordtxt.place_forget()
        errorla.place_forget()
    else:
        errorla.place(x=280, y=150)
        errortxt.set("wrong password")


def entetpress(event):
    global num
    global s, tl, player, list4
    agu = 0
    bgu = 0
    c = entxt.get()
    a = list(str(c))
    for i in range(0, 4):
        if re.match(r"^(?!.*(.).*\1)[0-9]{4}$", c) is None:
            abtxt.set("請重新輸入數字")
            return 0
    for i in range(0, 4):
        if a[i] == str(list4[i]):
            agu = agu + 1
        elif a[i] == str(list4[0]):
            bgu = bgu + 1
        elif a[i] == str(list4[1]):
            bgu = bgu + 1
        elif a[i] == str(list4[2]):
            bgu = bgu + 1
        elif a[i] == str(list4[3]):
            bgu = bgu + 1
        if agu == 4:
            btn['state'] = tk.NORMAL
            btntxt.set("按下按鈕開始")
            menu.pack()
            s1 = time.time()
            duration = s1 - s
            dd = round(duration,2)
            abtxt.set("time:"+str(dd)+"  guess:"+str(num+1))
            if player == "":
                num = num + 1
                cursor.execute("INSERT INTO score (name,timestamp,duration,times) VALUES (%s,%s,%s,%s);", (userID, tl, duration, num))
                db.commit()
            num = -1
            player = 1
        else:
            abtxt.set(str(agu) + "A" + str(bgu) + "B")
    num += 1
    roll.insert(END, str(num) + ". " + str(a[0]) + str(a[1]) + str(a[2]) + str(a[3]) + " : " + str(agu) + "A" + str(
        bgu) + "B")
    if num > 20:
        roll.delete(0, 0)


def start():
    global s
    roll.delete(0, END)
    btntxt.set("按enter輸入數字")
    btn['state'] = tk.DISABLED
    abtxt.set("開始輸入數字")
    global list4
    listr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0]
    list4 = []
    b = random.sample(listr, 4)
    list4.extend(b)
    print(list4)
    s = time.time()


def backmenu():
    btnv.place(x=315, y=200)
    btnlogin.place(x=285, y=225)
    ab.pack_forget()
    btn.pack_forget()
    en.pack_forget()
    roll.pack_forget()
    IDtxt.place(x=220, y=90)
    enaccounts.place(x=270, y=100)
    enpassword.place(x=270, y=130)
    passwordtxt.place(x=190, y=125)
    menu.pack_forget()


# ------------------------------------------------------------------
main = tk.Tk()  # 主視窗 main

main.geometry("640x480")

main.title("1a2b")

# ab-label
abtxt = tk.StringVar()
ab = tk.Label(main, textvariable=abtxt, fg="black", bg="white", font=("新細明體", 20), padx=30, pady=15)
abtxt.set("按下按鈕開始")

# btn-button
btntxt = tk.StringVar()
btn = tk.Button(main, textvariable=btntxt, command=start)
btntxt.set("start")

# en-entry
entxt = tk.StringVar()
en = tk.Entry(main, textvariable=entxt, exportselection=0)

# roll-listbox
roll = Listbox(main, width="20", height="20")

# menubtn-button
menu = tk.Button(main, text="menu", command=backmenu)

# btnvistor-Button
btnv = tk.Button(main, text="訪客", command=vistoren, padx=10, pady=1, bg='gray83', fg="gray30")
btnv.place(x=315, y=200)

# btnlogin-Button
btnlogin = tk.Button(main, text="Sign in", command=login, padx=30, pady=10, bg='DarkOrchid4', fg="snow")
btnlogin.place(x=285, y=225)
main.bind('<Return>', login)

# enaccounts-entry
enid = tk.StringVar()
enaccounts = tk.Entry(main, textvariable=enid)
enaccounts.place(x=270, y=100)

# enpassword-entry
enps = tk.StringVar()
enpassword = tk.Entry(main, textvariable=enps, show="*")
enpassword.place(x=270, y=130)

# IDtxt-label
accountstxt = tk.StringVar()
IDtxt = tk.Label(main, textvariable=accountstxt, fg="black", bg="white", font=("新細明體", 10), padx=10, pady=5)
accountstxt.set("ID")
IDtxt.place(x=220, y=90)

# passwordtxt-label
pstxt = tk.StringVar()
passwordtxt = tk.Label(main, textvariable=pstxt, fg="black", bg="white", font=("新細明體", 11), padx=10, pady=5)
pstxt.set("password")
passwordtxt.place(x=190, y=125)
# errorla-label
errortxt = tk.StringVar()
errorla = tk.Label(main, textvariable=errortxt, fg="red", padx=10, pady=8)
errortxt.set("wrong password")
main.mainloop()
