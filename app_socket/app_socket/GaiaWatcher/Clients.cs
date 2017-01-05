using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Clients : ConcurrentDictionary<Guid, Client> {

    }
}
