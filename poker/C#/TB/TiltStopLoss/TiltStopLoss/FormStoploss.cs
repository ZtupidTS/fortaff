using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics;
using System.Threading;
using System.IO;
using TiltStopLoss;
using StopLoss.Json;
using System.Runtime.InteropServices;
using System.Text.RegularExpressions;

namespace TiltStopLoss
{
    delegate void SetTextCallback(string text);
    delegate void SetTextCallbacks(String text, Color cor);
    delegate void SetButtonCallbacks(Boolean vi);
    
    public partial class Stoploss : Form
    {
        private Main wmain;
        private Db dbase;
        private Thread startcrono;
        private Thread startcronosnooze;
        private Thread startbb;
        private Thread startapp;
        private Boolean continu = true;
        Boolean stop = false;
        WMPLib.WindowsMediaPlayer player;
        private String[] sounds;
        private Boolean verapp;
        //data
        private Double stoploss;
        private Int64 handstop;
        private Int32 timestop;
        private Double stopwin;
        private int tracker;
        List<Tuple<String, String>> playeridname;
        private String time;
        private Double bb;
        private Double bbpeak;
        private Double peakover;
        Int64 handnumber = 0;
        Double bbmax;
        private Boolean sitout = true;
        private Int32 blocklimit;
        private Boolean hidebb;
        private Boolean visiblealwaysbb;
        private Boolean repeatwin;
        private Boolean repeatloss;
        private Boolean repeathand;
        private Boolean repeattime;
        private Double winintermediate;
        private Double lossintermediate;
        private Boolean snoozeb;
        private Int32 snoozeminute;
        private Boolean activesnooze = false;
        private Boolean starttime;
        private Double stoprake;
        private Double stopvpp;
        private Double rake = 0.0;
        private Double vpp = 0.0;
        private Double lastbbsum = 0;
        private Double lastbbsumnew = 0;
        private Int64 lastidhandload = 0;
        private Int64 Lastidhandnew = 0;
        private Boolean viewvpp;
        private Double stoplossmoney = 0.0;
        private Double stoplossintermediatemoney = 0.0;
        private Boolean ragequitSL;
        //private Int32 typemoney;
        //label
        Label LabelViewVpp;
        
        public Stoploss(Main wmain, List<Tuple<String,String>> playerid, Db db, String[] data, Boolean[] checkb, Int32 limit, Int32 snooze, String[] sound, int tracker, Double lastbbsumstart, Int64 idlasthand)
        {
            try
            {
                InitializeComponent();
                this.wmain = wmain;
                playeridname = playerid;
                dbase = db;
                //data
                //0 - stoploss
                //1- stophand
                //2 - stoptime
                //3 - stopwin
                //4 - stoplosspeak
                //5 - peakover
                //6 - lossintermediate
                //7 - winintermediate
                //8 - vpp
                //9 - rake
                //10 - stoplossintermediatemoney
                //11 - stoplossmoney
                //12 - 0: eur, 1: usd nao utilizo mais esse
                this.stoploss = new Utils().stringtoDouble(data[0]);
                handstop = new Utils().stringtoInt64(data[1]);
                timestop = new Utils().stringtoInt32(data[2]);
                stopwin = new Utils().stringtoDouble(data[3]);
                bbpeak = new Utils().stringtoDouble(data[4]);
                this.peakover = new Utils().stringtoDouble(data[5]);
                lossintermediate = new Utils().stringtoDouble(data[6]);
                winintermediate = new Utils().stringtoDouble(data[7]);
                stopvpp = new Utils().stringtoDouble(data[8]);
                stoprake = new Utils().stringtoDouble(data[9]);
                stoplossmoney = new Utils().stringtoDouble(data[11]);
                stoplossintermediatemoney = new Utils().stringtoDouble(data[10]);
                //typemoney = new Utils().stringtoInt32(data[12]);
                this.tracker = tracker;
                sounds = sound;
                blocklimit = limit;
                //checkb
                //0 - hidebb
                //1 - button set
                //2 - verify app
                //3 - rage quit
                //4 - snooze
                //5 - repeatwin
                //6 - repeatloss
                //7 - repeathand
                //8 - repeattime
                //9 - timerstart 1ª mão
                //10 - always visible bb
                //11 - viewvpp
                //12 - ragequitSL
                this.hidebb = checkb[0];
                if (hidebb)
                {
                    labelBb.Enabled = false;
                    labelBb.Visible = false;
                }
                //visible bb
                this.visiblealwaysbb = checkb[10];
                if (!hidebb && visiblealwaysbb)
                {
                    labelBb.Visible = true;
                }
                buttonSet.Visible = checkb[1];
                loadconfig();
                //cronometro
                starttime = checkb[9];
                if (!checkb[9])
                {
                    startcrono = new Thread(new ThreadStart(this.stoptimer));
                    startcrono.Start();
                }

                //calculo dos BB e hands
                startbb = new Thread(new ThreadStart(this.calculateBB));
                startbb.Start();
                //verify app
                verapp = checkb[2];
                if (verapp)
                {
                    startapp = new Thread(new ThreadStart(this.verifyApp));
                    startapp.Start();
                }
                buttonRageQuit.Visible = checkb[3];
                repeatwin = checkb[5];
                repeatloss = checkb[6];
                repeathand = checkb[7];
                repeattime = checkb[8];
                snoozeb = checkb[4];
                viewvpp = checkb[11];
                ragequitSL = checkb[12];
                snoozeminute = snooze;
                buttonSnooze.Visible = false;
                lastbbsum = lastbbsumstart;
                lastidhandload = idlasthand;

                //view vpp
                if (viewvpp)
                {
                    //original size 212,123
                    this.Size = new Size(212,147);
                    //inserir o labeltext dos vpp
                    LabelViewVpp = new Label();
                    LabelViewVpp.Location = new Point(9, 40);
                    //LabelViewVpp.Text = "100vpp";
                    LabelViewVpp.Size = new Size(90, 25);
                    LabelViewVpp.ForeColor = Color.Blue;
                    LabelViewVpp.Font = new Font("Microsoft Sans Serif", 10, System.Drawing.FontStyle.Bold);
                    this.Controls.Add(LabelViewVpp);
                }
            }
            catch (Exception e)
            {
                new Debug().LogMessage("method main stoploss: " + e.ToString());
            }
        }

        /// <summary>
        /// Quando fecho o form
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Stoploss_FormClosed(object sender, FormClosedEventArgs e)
        {
            continu = false;
            if (stop)
            {
                player.controls.stop();
            }
            String con = dbase.closeconDb();
            if (!con.Equals(""))
            {
                MessageBox.Show(con.ToString());
            }
            //guarda as config
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_stoploss.txt", false);
            w.Write("Location=" + location);
            w.WriteLine(); 
            w.Close();
            //fecho as minhas threads
            if (handnumber > 0 || !starttime)
            {
                startbb.Abort();
                startcrono.Abort();
            }
            if (verapp)
            {
                startapp.Abort();
            }
            if (activesnooze)
            {
                startcronosnooze.Abort();
            }
            //faço o new value na janela principal
            wmain.setNewValue(handstop.ToString(), stoploss.ToString(), timestop.ToString(), stopwin.ToString(), bbpeak.ToString(), peakover.ToString(), hidebb, winintermediate.ToString(), lossintermediate.ToString(), lastbbsumnew, Lastidhandnew);
            Double  bb100;
            if(bb == 0)
            {
                bb100 = 0;
            }else{
                bb100 = Math.Round((bb * 100) / handnumber, 2);
            }
            wmain.setValueSession(handnumber.ToString(), time, bb, bbmax, bb100);
            wmain.Show();
            wmain.ShowInTaskbar = true;
            wmain.WindowState = FormWindowState.Normal;
            wmain.Visible = true;            
        }

        /// <summary>
        /// Para lançar o método do close form
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonStop_Click(object sender, EventArgs e)
        {
            this.Close();            
        }

        /// <summary>
        /// Calcula os bb e hand para o stop
        /// </summary>
        private void calculateBB()
        {
            String yearmonth;
            Double bbinit = 0.0;
            Int64 lastidhand = 0;
            Int64 lastidsessionpt4 = 0;
            Double moneyinit = 0.0;

            #region define bbinit e lastidhand
            //permite definir aqui os valores iniciais de bbinit e lastidhand
            if (tracker == 1 || tracker == 2)
            {
                yearmonth = new Utils().yearmonth();
                if (lastbbsum == 0.0)
                {
                    //yearmonth = new Utils().yearmonth();
                    if (tracker == 2)//2 = hem2
                    {
                        for (int i = 0; i < playeridname.Count; i++)
                        {
                            bbinit += dbase.getSumBB(playeridname[i].Item1, yearmonth);
                        }
                        lastidhand = dbase.getLastValue("handhistories", "handhistory_id") + 1;
                    }
                    else
                    {
                        for (int i = 0; i < playeridname.Count; i++)
                        {
                            bbinit += dbase.getSumBBHem1(playeridname[i].Item1, yearmonth);
                        }
                        lastidhand = dbase.getLastValue("handhistories", "pokerhand_id") + 1;
                    }
                }
                else
                {
                    bbinit = lastbbsum;
                    if (lastidhandload == 0)
                    {
                        if (tracker == 2)//2 = hem2
                        {
                            lastidhand = dbase.getLastValue("handhistories", "handhistory_id") + 1;
                        }
                        else
                        {
                            lastidhand = dbase.getLastValue("handhistories", "pokerhand_id") + 1;
                        }
                    }
                    else
                    {
                        lastidhand = lastidhandload;
                    }
                }
            }
            else //pt4
            {
                yearmonth = new Utils().yearweek();
                if (lastbbsum == 0.0)
                {
                    for (int i = 0; i < playeridname.Count; i++)
                    {
                        bbinit += dbase.getSumBBPt4(playeridname[i].Item1, yearmonth);
                    }
                    lastidsessionpt4 = dbase.getLastValue("cash_table_session_summary", "id_session") + 1;
                }
                else
                {
                    bbinit = lastbbsum;
                    lastidsessionpt4 = lastidhandload;
                }
                //lastidsessionpt4 = dbase.getLastValue("cash_table_session_summary", "id_session") + 1;
                //vou buscar o last idhand de pt4
                lastidhand = dbase.getLastValue("cash_hand_histories", "id_hand") + 1;
            }
            #endregion

            #region calculo rake & vpp

            //aqui o calculo do rake e dos vpps
            Boolean rakeb = true;
            Boolean vppb = true;

            if (tracker == 1 || tracker == 2)
            {
                if (tracker == 2)//2 = hem2
                {
                    //rake
                    if (stoprake > 0.00)
                    {
                        try
                        {
                            var json = dbase.getRakeVpp<Stats>("select StatRakeAmount from stats");
                            if (json.Results.Capacity > 0)
                            {
                                String rakefinal = new Utils().resolveStringHem2(json.Results[0].Rake);
                                rake = new Utils().stringtoDouble(rakefinal);
                            }
                        }catch (Exception e)
                        {
                            new Debug().LogMessage("Error Rake:" + e.ToString());
                            rakeb = false;    
                        }
                    }
                    else
                    {
                        rakeb = false;
                    }
                    //vpp
                    if (stopvpp > 0.00 || viewvpp)
                    {
                        String error_vpp = "";
                        try
                        {
                            var json = dbase.getRakeVpp<Stats>("select StatNewStarsVPP from stats");
                            if (json.Results.Capacity > 0)
                            {
                                error_vpp = json.Results[0].NewStarsVPP.ToString();
                                //String vppfinal = new Utils().resolveStringRake(json.Results[0].Rake);
                                String vppfinal = new Utils().resolveStringHem2(json.Results[0].NewStarsVPP);
                                vpp = new Utils().stringtoDouble(vppfinal);                                
                            }
                        }
                        catch (Exception e)
                        {

                            new Debug().LogMessage("Error VPP:" + error_vpp);
                            new Debug().LogMessage("Error VPP:" + e.ToString());
                            vppb = false;
                        }
                    }
                    else
                    {
                        vppb = false;
                    }                       
                        
                }
            }

            #endregion

            #region moneyinit

            if (tracker == 2)//2 = hem2
            {
                //rake
                if (stoplossmoney > 0.00)
                {
                    //string sql = "";
                    
                    if (tracker == 2)
                    {
                        yearmonth = new Utils().yearmonth();
                        
                        if (tracker == 2)//2 = hem2
                        {
                            for (int i = 0; i < playeridname.Count; i++)
                            {
                                moneyinit += dbase.getSumMoney(playeridname[i].Item1, yearmonth);
                            }                            
                        }
                    }



                    //old by api hem2
                    //if (typemoney == 0)
                    //{
                    //    sql = "select StatNetAmountWonEUR from stats group by StatPlayerNameAndSite, statgametypedescription";
                    //}
                    //else
                    //{
                    //    sql = "select StatNetAmountWonUSD from stats group by StatPlayerNameAndSite, statgametypedescription";
                    //}
                    
                    //try
                    //{
                    //    var json = dbase.getRakeVpp<Stats>(sql);
                    //    if (json.Results.Capacity > 0)
                    //    {
                    //        //String[] deleteresultjson = {",", ".", "/", "€", "$"};
                    //        for (int i = 0; i < json.Results.Count; i++)
                    //        {
                    //            if (json.Results[i].GameType.IndexOfAny(new char[] { ',', '.', '/', '€', '$' }) != -1)
                    //            {
                    //                String moneyfinal = "";
                    //                if (typemoney == 0)
                    //                {
                    //                    moneyfinal = new Utils().resolveStringHem2(json.Results[i].NetWonEUR);
                    //                }
                    //                else
                    //                {
                    //                    moneyfinal = new Utils().resolveStringHem2(json.Results[i].NetWonUSD);
                    //                }
                    //                moneyinit += new Utils().stringtoDouble(moneyfinal);
                    //            }
                    //        }
                    //    }
                    //}
                    //catch (Exception e)
                    //{
                    //    new Debug().LogMessage("Error StoplossMoney:" + e.ToString());                        
                    //}
                }
            }

            #endregion

            bbmax = 0.0;
            Boolean intermediatewin = true;
            Boolean intermediateloss = true;
            Double vpptemp = 0.0;
            Double raketemp = 0.0;
            
            while (continu)
            {
                try
                {
                    #region BB
                    if (stoplossmoney <= 0.00)
                    {
                        //bb
                        bb = 0.0;
                        if (tracker == 1 || tracker == 2)
                        {
                            if (tracker == 2)//2 = hem2
                            {
                                for (int i = 0; i < playeridname.Count; i++)
                                {
                                    bb += dbase.getSumBB(playeridname[i].Item1, yearmonth);
                                }
                                lastbbsumnew = bb;
                            }
                            else
                            {
                                for (int i = 0; i < playeridname.Count; i++)
                                {
                                    bb += dbase.getSumBBHem1(playeridname[i].Item1, yearmonth);
                                }
                                lastbbsumnew = bb;
                            }
                        }
                        else //pt4
                        {
                            yearmonth = new Utils().yearweek();
                            for (int i = 0; i < playeridname.Count; i++)
                            {
                                bb += dbase.getSumBBPt4(playeridname[i].Item1, yearmonth);
                            }
                            lastbbsumnew = bb;
                        }

                        bb = Math.Round((bb - bbinit), 2);
                        if (this.labelBb.InvokeRequired)
                        {
                            SetTextCallback d = new SetTextCallback(SetTextBb);
                            this.Invoke(d, new object[] { bb.ToString() });
                        }
                        else
                        {
                            // It's on the same thread, no need for Invoke
                            this.labelBb.Text = bb.ToString();
                            if (!hidebb && visiblealwaysbb)
                            {
                                if (bb > 0)
                                {
                                    //labelBb.BackColor = Color.Green;
                                    labelBb.ForeColor = Color.Green;
                                }
                                else
                                {
                                    //labelBb.BackColor = Color.Red;
                                    labelBb.ForeColor = Color.Red;
                                }
                            }
                        }
                    }
                    #endregion

                    #region stoploss
                    //stoploss                    
                    if (stoploss > 0.0)
                    {
                        if (bb <= (0 - stoploss))
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[0], repeatloss);
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLoss !!!!", Color.Red);
                                snooze();
                                if (ragequitSL)
                                {
                                    rageQuit();
                                }
                            }                            
                        }
                    }
                    #endregion

                    #region stopwin

                    if (stopwin > 0.0)
                    {
                        if (bb >= stopwin)
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[2], repeatwin);
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopWin !!!!", Color.Green);
                                snooze();
                            }                            
                        }
                    }

                    #endregion

                    #region losspeak

                    //loss peak
                    if (bbpeak > 0.0)
                    {
                        if (bb > bbmax)
                        {
                            bbmax = bb;
                        }
                        else
                        {
                            if ((bbmax - bb) >= bbpeak && bbmax >= peakover)
                            {
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                    stop = true;
                                    //buttonSoundStop.Visible = true;
                                    labelStopSet("!!!! StopPeak !!!!", Color.Red);
                                    snooze();
                                }
                            }
                            else
                            {
                                if (labelStop.Text.Equals("!!!! StopPeak !!!!") && stop)
                                {
                                    StopsoundClearLabel();
                                }
                            }
                        }
                    }

                    #endregion

                    #region lossintermediate

                    //lossintermediate
                    if (lossintermediate > 0.0 && intermediateloss && !stop)
                    {
                        if (bb <= (0 - lossintermediate))
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[4], false);
                                //stop = true;
                                intermediateloss = false;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! LossIntermediate !!!!", Color.Red);
                                Thread.Sleep(5000);
                                labelStopSet("", Color.White);
                                if (!intermediatewin)
                                {
                                    intermediatewin = true;
                                }
                            }
                        }
                    }
                    else
                    {
                        if (!intermediateloss && !stop && bb > 0)
                        {
                            intermediateloss = true;
                        }
                    }

                    #endregion

                    #region winintermediate

                    if (winintermediate > 0.0 && intermediatewin && !stop)
                    {
                        if (bb >= winintermediate)
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[5], false);
                                //stop = true;
                                intermediatewin = false;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! WinIntermediate !!!!", Color.Green);
                                Thread.Sleep(5000);
                                labelStopSet("", Color.White);
                                if (!intermediateloss)
                                {
                                    intermediateloss = true;
                                }
                            }
                        }
                    }
                    else
                    {
                        if (!intermediatewin && !stop && bb < 0)
                        {
                            intermediatewin = true;
                        }
                    }

                    #endregion

                    #region count hand & start timer

                    //hand
                    String hand = "";
                    //aqui vou buscar a hand para depois ver os limites e contar as hands para hem1 e hem2
                    if (tracker == 1 || tracker == 2)
                    {
                        if (tracker == 2)//2 = hem2
                        {
                            hand = dbase.getHand(lastidhand, "handhistories", "handhistory_id", "handhistory");//hem2
                        }
                        else
                        {
                            hand = dbase.getHand(lastidhand, "handhistories", "pokerhand_id", "handhistory");//hem1
                        }
                    }
                    else
                    {
                        hand = dbase.getHand(lastidhand, "cash_hand_histories", "id_hand", "history");//pt4
                    }


                    if (tracker == 1 || tracker == 2)
                    {
                        if (!hand.Equals(""))
                        {
                            lastidhand++;
                            Lastidhandnew = lastidhand;
                            for (int i = 0; i < playeridname.Count; i++)
                            {
                                if (hand.Contains(playeridname[i].Item2) && !hand.Contains("Tournament"))
                                {
                                    Boolean fim = false;
                                    //winamax
                                    if (hand.ToLower().Contains("winamax"))
                                    {
                                        fim = true;
                                        String[] handsplit = hand.Split(new string[] { "PRE-FLOP" }, StringSplitOptions.RemoveEmptyEntries);
                                        if (handsplit[1].Contains(playeridname[i].Item2))
                                        {
                                            handnumber++;
                                            i = playeridname.Count;
                                        }
                                    }
                                    //ipoker file xml
                                    if (hand.ToLower().Contains("xml") && !fim)
                                    {
                                        fim = true;
                                        String handnew = hand.Replace("\"", "");
                                        String[] handsplit = handnew.Split(new string[] { "round" }, StringSplitOptions.RemoveEmptyEntries);
                                        for (int l = 1; l < handsplit.Count(); l++)
                                        {
                                            if (handsplit[l].Contains(playeridname[i].Item2))
                                            {
                                                handnumber++;
                                                i = playeridname.Count;
                                                l = handsplit.Count();
                                            }
                                        }
                                    }
                                    //pokerstars.
                                    if (!fim)
                                    {
                                        handnumber++;
                                        i = playeridname.Count;
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        //pt4
                        handnumber = 0;
                        for (int i = 0; i < playeridname.Count; i++)
                        {
                            handnumber += dbase.getHandPt4(playeridname[i].Item1, lastidsessionpt4);
                        }
                        Lastidhandnew = dbase.getLastValue("cash_table_session_summary", "id_session") + 1;
                    }

                    if (this.labelBb.InvokeRequired)
                    {
                        SetTextCallback d = new SetTextCallback(SetTextHands);
                        this.Invoke(d, new object[] { handnumber.ToString() });
                    }
                    else
                    {
                        // It's on the same thread, no need for Invoke
                        this.labelHands.Text = handnumber.ToString();
                    }
                    if (handstop != 0)
                    {
                        if (handstop <= handnumber)
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[3], repeathand);
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopHand !!!!", Color.Blue);
                                snooze();
                            }                            
                        }
                    }

                    //para começar a contar mãos.
                    if (starttime && handnumber > 0)
                    {
                        startcrono = new Thread(new ThreadStart(this.stoptimer));
                        startcrono.Start();
                        starttime = false;
                    }

                    #endregion

                    #region stoplimit

                    //stoplimit
                    if (blocklimit != 0)
                    {
                        stopLimit(hand);
                    }

                    #endregion

                    #region stoprake

                    //rake
                    if (rakeb)
                    {
                        if (tracker == 1 || tracker == 2)
                        {
                            if (tracker == 2)//2 = hem2
                            {
                                var json = dbase.getRakeVpp<Stats>("select StatRakeAmount from stats");
                                try
                                {
                                    String raketempfinal = new Utils().resolveStringHem2(json.Results[0].Rake);
                                    raketemp = new Utils().stringtoDouble(raketempfinal);                                    
                                }
                                catch (Exception e)
                                {
                                    new Debug().LogMessage("Error rake : "+ e.ToString());
                                }
                            }
                        }
                        if (stoprake < (raketemp - rake))
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[5], false);
                                labelStopSet("!!!! StopRake !!!!", Color.Green);
                                Thread.Sleep(5000);
                                labelStopSet("", Color.White);
                                stoprake = 99999;
                            }
                        }
                    }

                    #endregion

                    #region vpp

                    //vpp
                    if (vppb)
                    {
                        if (tracker == 1 || tracker == 2)
                        {
                            if (tracker == 2)//2 = hem2
                            {
                                var json = dbase.getRakeVpp<Stats>("select StatNewStarsVPP from stats");
                                try
                                {
                                    String vpptempfinal = new Utils().resolveStringHem2(json.Results[0].NewStarsVPP);
                                    vpptemp = new Utils().stringtoDouble(vpptempfinal);
                                    
                                }
                                catch (Exception e)
                                {
                                    new Debug().LogMessage("Error vpp : " + e.ToString());
                                }
                            }
                        }

                        if (viewvpp)
                        {
                            Double vpplabel = Math.Round(vpptemp - vpp, 2);
                            labelViewVpp(vpplabel + " Vpp");
                        }

                        if (stopvpp < (vpptemp - vpp) && stopvpp > 0.00)
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[5], false);
                                labelStopSet("!!!! StopVPP !!!!", Color.Green);
                                Thread.Sleep(5000);
                                labelStopSet("", Color.White);
                                stopvpp = 9999999;
                            }
                        }

                    }

                    #endregion

                    #region stoplossmoney

                    //bb
                    if (tracker == 2)//2 = hem2
                    {
                        if (stoplossmoney > 0.00)
                        {
                            Double moneytemp = 0.0;
                            Double moneytempfinal = 0.0;

                            if (tracker == 2)
                            {
                                yearmonth = new Utils().yearmonth();

                                if (tracker == 2)//2 = hem2
                                {
                                    for (int i = 0; i < playeridname.Count; i++)
                                    {
                                        moneytemp += dbase.getSumMoney(playeridname[i].Item1, yearmonth);
                                    }
                                }
                            }

                            //old by api hem2
                            //string sql = "";
                            //if (typemoney == 0)//€
                            //{
                            //    sql = "select StatNetAmountWonEUR from stats group by StatPlayerNameAndSite, statgametypedescription";
                            //}
                            //else//$
                            //{
                            //    sql = "select StatNetAmountWonUSD from stats group by StatPlayerNameAndSite, statgametypedescription";
                            //}

                            //try
                            //{
                            //    var json = dbase.getRakeVpp<Stats>(sql);
                            //    if (json.Results.Capacity > 0)
                            //    {
                                    
                            //        String[] deleteresultjson = { ",", ".", "/", "€", "$" };
                            //        for (int i = 0; i < json.Results.Count; i++)
                            //        {
                            //            if (json.Results[i].GameType.IndexOfAny(new char[] { ',', '.', '/', '€', '$' }) != -1)
                            //            {
                            //                String moneyfinal = "";
                            //                if (typemoney == 0)
                            //                {
                            //                    moneyfinal = new Utils().resolveStringHem2(json.Results[i].NetWonEUR);
                            //                }
                            //                else
                            //                {
                            //                    moneyfinal = new Utils().resolveStringHem2(json.Results[i].NetWonUSD);
                            //                }
                            //                moneytemp += new Utils().stringtoDouble(moneyfinal);
                            //            }
                            //        }
                            //    }
                            //}
                            //catch (Exception e)
                            //{
                            //    new Debug().LogMessage("Error StoplossMoney:" + e.ToString());
                            //}


                            moneytempfinal = Math.Round((moneytemp - moneyinit), 2);

                            if (this.labelBb.InvokeRequired)
                            {
                                SetTextCallback d = new SetTextCallback(SetTextBb);
                                this.Invoke(d, new object[] { moneytempfinal.ToString() });
                            }
                            else
                            {
                                // It's on the same thread, no need for Invoke
                                this.labelBb.Text = moneytempfinal.ToString();
                                if (!hidebb && visiblealwaysbb)
                                {
                                    if (moneytempfinal > 0)
                                    {
                                        //labelBb.BackColor = Color.Green;
                                        labelBb.ForeColor = Color.Green;
                                    }
                                    else
                                    {
                                        //labelBb.BackColor = Color.Red;
                                        labelBb.ForeColor = Color.Red;
                                    }
                                }
                            }
                            //stoplossmoney                          
                            if (moneytempfinal <= (0 - stoplossmoney))
                            {
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                    stop = true;
                                    //buttonSoundStop.Visible = true;
                                    labelStopSet("!!!! StopLoss !!!!", Color.Red);
                                    snooze();
                                }
                            }
                            //stoplossintermediatemoney
                            if (stoplossintermediatemoney > 0.0 && intermediateloss && !stop)
                            {
                                if (moneytempfinal <= (0 - stoplossintermediatemoney))
                                {
                                    if (!stop)
                                    {
                                        player = new Utils().playsound(sounds[4], false);
                                        //stop = true;
                                        intermediateloss = false;
                                        //buttonSoundStop.Visible = true;
                                        labelStopSet("!!!! LossIntermediate !!!!", Color.Red);
                                        Thread.Sleep(5000);
                                        labelStopSet("", Color.White);
                                        if (!intermediatewin)
                                        {
                                            intermediatewin = true;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if (!intermediateloss && !stop && moneytempfinal >= 0)
                                {
                                    intermediateloss = true;
                                }
                            }
                        }
                    }

                    #endregion

                    //Thread.Sleep(250);
                }
                catch (Exception ex)
                {
                    new Debug().LogMessage(ex.ToString());
                }
            }
            
        }

        /// <summary>
        /// stoplimit for brm
        /// </summary>
        /// <param name="hand"></param>
        private void stopLimit(String hand)
        {
            Int16 nl = 0;
            for (int i = 0; i < playeridname.Count; i++)
            {
                if (hand.Contains(playeridname[i].Item2))
                {
                    //pokerstars
                    if (hand.ToLower().Contains("pokerstars") && !hand.ToLower().Contains("tournament"))
                    {
                        nl = new Utils().getNlPs(hand);
                        if (nl.Equals(0))
                        {
                            new Debug().LogAlert("Problem limit not defined", "Problem_Limit");
                        }
                        else
                        {
                            //je vérifie si la limite rendu é supérieur a la limite accepter
                            if (nl > blocklimit)
                            {
                                //aqui apita e change le text du label
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);                                    
                                }
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLimit !!!!", Color.Red);
                                //close poker stars
                                new Utils().detectApps("PokerStars");
                            }
                        }
                    }
                    //winamax
                    if (hand.ToLower().Contains("winamax") && !hand.ToLower().Contains("tournament") && !stop)
                    {
                        nl = new Utils().getNlPs(hand);
                        if (nl.Equals(0))
                        {
                            new Debug().LogAlert("Problem limit not defined", "Problem_Limit");
                        }
                        else
                        {
                            //je vérifie si la limite rendu é supérieur a la limite accepter
                            if (nl > blocklimit)
                            {
                                //aqui apita e change le text du label
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                }
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLimit !!!!", Color.Red);
                                //close poker stars
                                new Utils().detectApps("Winamax Poker");
                            }
                        }
                    }
                    //ipoker
                    if (hand.ToLower().Contains("xml") && !hand.ToLower().Contains("tournament") && !stop)
                    {
                        nl = new Utils().getNlIpoker(hand);
                        if (nl.Equals(0))
                        {
                            new Debug().LogAlert("Problem limit not defined", "Problem_Limit");
                        }
                        else
                        {
                            //je vérifie si la limite rendu é supérieur a la limite accepter
                            if (nl > blocklimit)
                            {
                                //aqui apita e change le text du label
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                }
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLimit !!!!", Color.Red);
                                //close poker stars
                                new Utils().detectApps("casino");
                            }
                        }
                    }
                    //wpt and party poker
                    if (hand.ToLower().Contains("* hand his") && !hand.ToLower().Contains("tournament") && !stop)
                    {
                        nl = new Utils().getNlpp(hand);
                        if (nl.Equals(0))
                        {
                            new Debug().LogAlert("Problem limit not defined", "Problem_Limit");
                        }
                        else
                        {
                            //je vérifie si la limite rendu é supérieur a la limite accepter
                            if (nl > blocklimit)
                            {
                                //aqui apita e change le text du label
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                }
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLimit !!!!", Color.Red);
                                //close poker stars
                                new Utils().detectApps("wpt");
                            }
                        }
                    }
                    //full tilt
                    if (hand.ToLower().Contains("Full Tilt") && !hand.ToLower().Contains("tournament"))
                    {
                        nl = new Utils().getNlPs(hand);
                        if (nl.Equals(0))
                        {
                            new Debug().LogAlert("Problem limit not defined", "Problem_Limit");
                        }
                        else
                        {
                            //je vérifie si la limite rendu é supérieur a la limite accepter
                            if (nl > blocklimit)
                            {
                                //aqui apita e change le text du label
                                if (!stop)
                                {
                                    player = new Utils().playsound(sounds[0], repeatloss);
                                }
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopLimit !!!!", Color.Red);
                                //close poker stars
                                new Utils().detectApps("FullTiltPoker");
                            }
                        }
                    }
                }
            }
            
        }

        /// <summary>
        /// cronometro do tempo da sessão e para o stop time
        /// </summary>
        private void stoptimer()
        {
            int hour = 0;
            int minute = 0;
            int seconde = 0;
            int minutetostop = 0;
            
            while (continu)
            {
                while (sitout)
                {
                    Thread.Sleep(1000);
                    seconde++;
                    if (seconde == 60)
                    {
                        seconde = 0;
                        minutetostop++;
                        minute++;
                        if (minute == 60)
                        {
                            minute = 0;
                            hour++;
                        }
                    }
                    String minutest;
                    if (minute < 10)
                    {
                        minutest = "0" + minute;
                    }
                    else
                    {
                        minutest = "" + minute;
                    }
                    String secondest;
                    if (seconde < 10)
                    {
                        secondest = "0" + seconde;
                    }
                    else
                    {
                        secondest = "" + seconde;
                    }
                    time = "0" + hour + ":" + minutest + ":" + secondest;
                    if (this.labelTimer.InvokeRequired)
                    {
                        SetTextCallback d = new SetTextCallback(SetTextTimer);
                        this.Invoke(d, new object[] { time });
                    }
                    else
                    {
                        // It's on the same thread, no need for Invoke
                        this.labelTimer.Text = time;
                    }
                    if (timestop != 0)
                    {
                        if (timestop <= minutetostop)
                        {
                            if (!stop)
                            {
                                player = new Utils().playsound(sounds[1], repeattime);
                                stop = true;
                                //buttonSoundStop.Visible = true;
                                labelStopSet("!!!! StopTime !!!!", Color.Black);
                                snooze();
                            }                            
                        }
                    }
                }
            }
        }

        #region set label
        private void SetTextTimer(string text)
        {
            this.labelTimer.Text = text;
        }

        private void SetTextBb(string text)
        {
            this.labelBb.Text = text;
            if (!hidebb && visiblealwaysbb)
            {
                Double value = Convert.ToDouble(labelBb.Text.ToString());
                if (value > 0)
                {
                    //labelBb.BackColor = Color.Green;
                    labelBb.ForeColor = Color.Green;
                }
                else
                {
                    //labelBb.BackColor = Color.Red;
                    labelBb.ForeColor = Color.Red;
                }
            }
        }

        private void SetTextHands(string text)
        {
            this.labelHands.Text = text;
        }

        private void setLabelStop(String text, Color cor)
        {
            this.labelStop.Text = text;
            this.labelStop.ForeColor = cor;
        }

        private void setLabelViewVpp(String text)
        {
            this.LabelViewVpp.Text = text;            
        }

        private void labelStopSet(String text, Color cor)
        {
            if (this.labelBb.InvokeRequired)
            {
                SetTextCallbacks d = new SetTextCallbacks(setLabelStop);
                this.Invoke(d, new object[] { text, cor });
            }
            else
            {
                // It's on the same thread, no need for Invoke
                this.labelStop.Text = text;
                this.labelStop.ForeColor = cor;
            }
        }

        private void labelViewVpp(String text)
        {
            if (this.LabelViewVpp.InvokeRequired)
            {
                SetTextCallback d = new SetTextCallback(setLabelViewVpp);
                this.Invoke(d, new object[] { text });
            }
            else
            {
                // It's on the same thread, no need for Invoke
                this.labelStop.Text = text;                
            }
        }

        private void SetButtonSnoozeVi(Boolean vi)
        {
            this.buttonSnooze.Visible = vi;
        }

        #endregion

        /// <summary>
        /// mudar o texto das bb e po-lo visível ao passsar o rato por cima.
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void labelBb_MouseHover(object sender, EventArgs e)
        {
            if (!hidebb && !visiblealwaysbb)
            {
                Double value = Convert.ToDouble(labelBb.Text.ToString());
                if (value > 0)
                {
                    //labelBb.BackColor = Color.Green;
                    labelBb.ForeColor = Color.Green;
                }
                else
                {
                    //labelBb.BackColor = Color.Red;
                    labelBb.ForeColor = Color.Red;
                }
                labelBb.Visible = true;
            }
        }

        /// <summary>
        /// põe o label das BBs novmaente invisível.
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void labelBb_MouseLeave(object sender, EventArgs e)
        {
            if (!hidebb && !visiblealwaysbb)
            {
                labelBb.ForeColor = Color.White;
            }
        }

        #region load config
        /// <summary>
        /// carregas as configs
        /// </summary>
        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_stoploss.txt";
            if (File.Exists(filepath))
            {
                string line;
                // Read the file and display it line by line.
                System.IO.StreamReader file = new System.IO.StreamReader(filepath);
                while ((line = file.ReadLine()) != null)
                {
                    String[] array = line.Split('=');
                    configframe(array);
                }
                file.Close();
            }
        }

        private void configframe(String[] line)
        {
            switch (line[0])
            {
                case "Location":
                    String[] loc = line[1].Split(',');
                    this.StartPosition = FormStartPosition.Manual;
                    this.Location = new Point(int.Parse(loc[0]), int.Parse(loc[1]));
                    break;               
            }
        }

        #endregion

        /// <summary>
        /// Permite ajustar os valores depois de arrancar com o programa
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonSet_Click(object sender, EventArgs e)
        {
            StopLoss.FormSet fs = new StopLoss.FormSet(this, stoploss, handstop, timestop, stopwin, bbpeak, peakover, this.hidebb, winintermediate, lossintermediate);
            fs.Show();
        }

        /// <summary>
        /// recebe os novos valores
        /// </summary>
        /// <param name="hand"></param>
        /// <param name="loss"></param>
        /// <param name="time"></param>
        public void setNewValue(Int64 hand, Double loss, Int32 time, Double win, Double losspeak, Double peakover, Boolean hidebb, Double wininter, Double lossinter)
        {
            if (time > timestop && labelStop.Text.Equals("!!!! StopTime !!!!"))
            {
                StopsoundClearLabel();
            }
            this.timestop = time;
            if (hand > handstop && labelStop.Text.Equals("!!!! StopHand !!!!"))
            {
                StopsoundClearLabel();
            }
            this.handstop = hand;
            if (bb > (0 - loss) && labelStop.Text.Equals("!!!! StopLoss !!!!"))
            {
                StopsoundClearLabel();
            }
            this.stoploss = loss;
            if (bb < win && labelStop.Text.Equals("!!!! StopWin !!!!"))
            {
                StopsoundClearLabel();
            }
            this.stopwin = win;
            this.bbpeak = losspeak;
            this.peakover = peakover;
            winintermediate = wininter;
            lossintermediate = lossinter;
            if (hidebb)
            {
                this.hidebb = true;
                labelBb.Enabled = false;
                labelBb.Visible = false;
            }
            else
            {
                labelBb.Enabled = true;
                labelBb.Visible = true;
                this.hidebb = false;
            }
        }

        /// <summary>
        /// Quando volta a não estar nos critérios do stop
        /// </summary>
        private void StopsoundClearLabel()
        {
            stop = false;
            labelStopSet("__________________", Color.White);
            if (snoozeb)
            {
                if (this.buttonSnooze.InvokeRequired)
                {
                    SetButtonCallbacks d = new SetButtonCallbacks(SetButtonSnoozeVi);
                    this.Invoke(d, new object[] { false });
                }
                else
                {
                    // It's on the same thread, no need for Invoke
                    this.buttonSnooze.Visible = false;
                }
                if (activesnooze)
                {
                    startcronosnooze.Abort();
                }
            }
            player.controls.stop();
        }

        /// <summary>
        /// permite clicar e fazer um stop ao tempo em caso de sitout
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void labelTimer_Click(object sender, EventArgs e)
        {
            if (sitout)
            {
                sitout = false;
                labelStopSet("!!!! Timer Stopped !!!!", Color.Blue);
            }
            else
            {
                sitout = true;
                labelStopSet("", Color.Blue);
            }
        }

        /// <summary>
        /// Aqui verifico se o skype, firefox, chrome e ie estão abertos.
        /// Se estão só dou uma alerta sobre isso, e caso o user a fache deixa de dar o alerta
        /// </summary>
        private void verifyApp()
        {
            string[] apps = { "Skype", "chrome", "firefox", "iexplore" };
            while (continu)
            {
                Boolean appopen = false;
                foreach (String app in apps)
                {
                    if (!appopen)
                    {
                        appopen = new Utils().detectApp(app);
                    }                    
                    if (appopen && !stop)
                    {
                        //player = new Utils().playSoundIntermediate(sounds[0]);
                        labelStopSet("!!!! StopApplication !!!!", Color.Red);
                    }
                    else
                    {
                        if (!stop)
                        {
                            labelStopSet("", Color.White);
                        }
                    }
                }                
            }
        }

        #region RageQuit

        /// <summary>
        /// RAGEQUIT
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonRageQuit_Click(object sender, EventArgs e)
        {
            rageQuit();
        }

        private void rageQuit()
        {
            String[] rooms = { "pokerstars", "winamax", "casino", "FullTiltPoker", "poker", "FullTiltPokerEU", "Tiger Gaming" };
            foreach (String room in rooms)
            {
                new Utils().detectApps(room);
            }
            this.Close();
        }

        #endregion

        /// <summary>
        /// view button snooze
        /// </summary>
        private void snooze()
        {
            if (snoozeb)
            {
                if (this.buttonSnooze.InvokeRequired)
                {
                    SetButtonCallbacks d = new SetButtonCallbacks(SetButtonSnoozeVi);
                    this.Invoke(d, new object[] { true });
                }
                else
                {
                    // It's on the same thread, no need for Invoke
                    this.buttonSnooze.Visible = true;
                }
                
                //buttonSnooze.Visible = true;
            }
        }

        /// <summary>
        /// thread pour lancer le timer égal au temps du snooze pour relancer le player.
        /// le stop = true a ce moment la
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonSnooze_Click(object sender, EventArgs e)
        {
            player.controls.pause();
            if (this.buttonSnooze.InvokeRequired)
            {
                SetButtonCallbacks d = new SetButtonCallbacks(SetButtonSnoozeVi);
                this.Invoke(d, new object[] { false });
            }
            else
            {
                // It's on the same thread, no need for Invoke
                this.buttonSnooze.Visible = false;
            }
            startcronosnooze = new Thread(new ThreadStart(this.timerSnooze));
            startcronosnooze.Start();            
        }

        /// <summary>
        /// Son en pause
        /// </summary>
        private void timerSnooze()
        {
            activesnooze = true;
            int seconde = 0;
            int finaltime = snoozeminute * 60;            
            while (seconde < finaltime)
            {
                Thread.Sleep(1000);
                seconde++;
            }
            player.controls.play();
            if (this.buttonSnooze.InvokeRequired)
            {
                SetButtonCallbacks d = new SetButtonCallbacks(SetButtonSnoozeVi);
                this.Invoke(d, new object[] { true });
            }
            else
            {
                // It's on the same thread, no need for Invoke
                this.buttonSnooze.Visible = true;
            }
            //activesnooze = false;
        }


    }
}
