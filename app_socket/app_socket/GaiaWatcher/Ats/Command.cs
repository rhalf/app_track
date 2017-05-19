using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;

namespace GaiaWatcher {

    public class Command : Service {

        private static Command instance = null;

        public static Command getInstance () {
            if (instance == null) {
                instance = new Command();
            }
            return instance;
        }
        private Command () : base(Service.COMMAND) {

        }




        public override CommandData parseCommandData (byte[] data) {
            //unitImei,unitType,unitBrand,commandType,commandParam
            CommandData commandData = null;

            string parse = ASCIIEncoding.UTF8.GetString(data);

            string[] parses = parse.Split(',');

            commandData = new CommandData {
                imei = parses[0],
                service = new Service(parses[1]),
                command = parses[3],
                parameter = parses[4]

            };


            return commandData;
        }
    }
}