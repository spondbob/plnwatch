﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ReadMdb
{
    class Program
    {
        public static void ClearCurrentConsoleLine()
        {
            int currentLineCursor = Console.CursorTop;
            Console.SetCursorPosition(0, Console.CursorTop);
            for (int i = 0; i < Console.WindowWidth; i++)
                Console.Write(" ");
            Console.SetCursorPosition(0, currentLineCursor);
        }

        [STAThread]
        static void Main(string[] args)
        {
            new MdbReader();
        }
    }
}
