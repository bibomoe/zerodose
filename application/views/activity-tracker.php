
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Activity Tracker</h3>
                                <!-- <p class="text-subtitle text-muted">Number of ZD children in targeted areas​</p> -->
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Activity Tracker</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- // Basic Horizontal form layout section end -->
                </div>
                <div class="page-content"> 
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body">
                                            <label for="partnersInput" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Gavi MICs Partners/implementers </label>
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                            <select id="partnersInput" class="form-select" style="width: 100%; max-width: 300px; height: 48px; font-size: 1rem;">
                                                    <option selected>Ministry of Health Indonesia</option>
                                                    <option>CHAI</option>
                                                    <option>WHO</option>
                                                    <option>UNICEF</option>
                                                    <option>UNDP</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                    <i class="bi bi-filter"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Activities Conducted</h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th>Activity Code</th>
                                                        <th>Description</th>
                                                        <th>Year 1</th>
                                                        <th>Year 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>(1.1)</td>
                                                        <td>Improve the accuracy of annual projection for vaccines and logistics by providing training for provincial and districts health officials. The projection will be generated through SMILE with target population as the input for projecting all antigents and related logistics needed at all levels, including Primary Health Care. Moreover, the data will be integrated to the procurement requests form in Directorate General of Medicine and Health Supplies (limit human error)</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.2)</td>
                                                        <td>Strengthen immunization service delivery at private sectors (capacity building for vaccinators and logistic officers in the private sectors), and post training monitoring.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.3)</td>
                                                        <td>Providing technical assistance on identifying zero dose children, increasing community demand, and removing barriers at selected provinces.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.4)</td>
                                                        <td>Implement supportive supervision in selected provinces.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.5)</td>
                                                        <td>Develop and implement post training monitoring and formulate recommendation to maintain health workers capacity in both public and private sectors.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.6)</td>
                                                        <td>Providing technical assistance maintain skills and competencies of vaccine logistics managers all health facilities in 10 provinces (5,822 puskesmas) in updating and utilizing SMILE application for better planning and visibility of inventory at national and sub-national level</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.7)</td>
                                                        <td>Engage health institutions and professional organizations to strengthen curricula on safe immunization delivery.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.8)</td>
                                                        <td>Workshop on safe injection and multiple injections in selected provinces.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.9)</td>
                                                        <td>Roll-out of SMILE for routine immunization to be ready for use at the national level, and to support the supply-chain management during catch-up immunization program by enhancing its scalability, functions, performance and security. The enhancement include integration between SMILE and individual registry application (ASIK), IHS (information health system/dashboard) and also other information systems, as well as the process of handing over SMILE from UNDP to the MoH</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.10)</td>
                                                        <td>Rapid convenience assessment of complete routine immunization in selected areas.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.11)</td>
                                                        <td>Improving data management and linkage in and between public and private providers for RI; towards better data visibility for accurate zero dose identification and targeting in selected provinces.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.12)</td>
                                                        <td>Strengthen routine data review, monitoring and coordination of RI services in select provinces/districts through involvement of private facilities (MOH, UNICEF, CHAI).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.13)</td>
                                                        <td>Tailoring and specifying service delivery plans and strategy following data review and program monitoring, to increase effectiveness of RI service delivery at district and PHC level, towards reaching ZD by including strengthening public private partnership model.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.14)</td>
                                                        <td>Adapt service delivery plans and strategy following data review and program monitoring, to continuously improve access and utilization to RI services at district and PHC level.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(1.15)</td>
                                                        <td>Develop a full scope of work on country guidelines, assessment and development of real-time dashboard on cold-chain capacity at health facility, also to develop a temperature data dashboard where the data will be transmitted regularly from 5,000 cold-chain points.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.1)</td>
                                                        <td>Develop individual electronic immunization registry and implementation roadmap.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.2)</td>
                                                        <td>Disseminate and develop one health dashboard particularly on logistics of vaccines, medicines, health supplies for public consumption.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.3)</td>
                                                        <td>Disseminate electronic immunization registry at public and private health facility.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.4)</td>
                                                        <td>Coordinate with Civil Registry, Ministry of Home Affairs and other cross ministries on denominator data validation.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.5)</td>
                                                        <td>Review the functionality, security and performance of electronic immunization logistic registry.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.6)</td>
                                                        <td>Larger scale of cost-benefit analysis on digitalization of immunization program conducted through the development of guidelines, enhance & update e-learning platform, video tutorials, and attending 15 day international workshop.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.7)</td>
                                                        <td>Leverage use of GIS and data triangulation analysis from Maternal and Child Health, Vaccine Preventable Diseases (VPD) surveillance, and other programs to map underserved areas in select province/districts.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.8)</td>
                                                        <td>Characterize, categorize and prioritize catchment areas based on a mix of core indicators performance in province level.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.9)</td>
                                                        <td>Identify specific barriers (gender-, demand-, and supply-related) to access and utilization of RI services in prioritized districts and facilities, by leveraging Human Centered Design, a creative approach for innovative solution.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.10)</td>
                                                        <td>Regular feedback on zero dose analysis at national and subnational level, including data triangulation with VPD surveillance.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.11)</td>
                                                        <td>Engage local government leaders and relevant units in developing and updating microplanning (MOH, UNICEF).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.12)</td>
                                                        <td>Engage professional organization and health institution to allocate/distribute additional human resources to reach hard to reach area.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.13)</td>
                                                        <td>Engage with Ministry of Transportation, Army, Police and other relevant stakeholders to assist in vaccine and logistic distribution, also service delivery.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(2.14)</td>
                                                        <td>Resource mobilization from private sectors for implementing SOS.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.1)</td>
                                                        <td>Conduct vaccine acceptance study on routine immunization using BeSD approach at selected district/province.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.2)</td>
                                                        <td>Develop national communication strategy, including innovative communication intervention in reaching hard to reach communities.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.3)</td>
                                                        <td>Online quarterly survey regarding community demand on routine immunization.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.4)</td>
                                                        <td>Empowerment of CSO to increase community demand on routine immunization at grass root level.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.5)</td>
                                                        <td>Refreshing media communication group to support boosting community confidence in vaccine safety.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.6)</td>
                                                        <td>Facilitate coordination/advocacy meeting with existing community structures across health programs and sectors to increase public participation in outreach activities and/or other adapted service delivery approach.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.7)</td>
                                                        <td>Promote targeted engagements between health facility and local community, including community leaders, civil society organizations, specific groups to reinforce community demand and participation in outreach activities.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.8)</td>
                                                        <td>Establish Private Health Sector Task Force for immunization.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(3.9)</td>
                                                        <td>Strengthen public-private partnership with variety of potential private providers (e.g. midwives, private clinics).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(4.1)</td>
                                                        <td>Regular coordination and review meeting on availability of vaccine and logistics at national and subnational level.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(4.2)</td>
                                                        <td>Data review meeting on vaccine logistics at subnational level to ensure stock availability and reduce ZD occurrence due to stock-out.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(4.3)</td>
                                                        <td>Develop, refine and disseminate plans, tools and technical guidelines for action, on cold chain inventory to ensure review meetings are acted upon.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(4.4)</td>
                                                        <td>Develop a performance monitoring web-based dashboard with clear process and tools to track implementation of zero-dose strategy and provide feedback to the implementation team.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(4.5)</td>
                                                        <td>Improves the overall efficiency of vaccine distribution to maintain optimal stock at all levels through real-time and accountable monitoring tools combined with joint-routine spot-check (MoH/Inspectorate General, EPI, and Provincial Health Office).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(5.1)</td>
                                                        <td>Increase national and subnational government commitment on immunization program based on findings and recommendation of GAVI (Post) Transition Risk Assessment (GTRA).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(5.2)</td>
                                                        <td>Assess existing flow of funds for immunization programs and identify resources (public & private sector) including the bottlenecks for service delivery (tracking budget allocation and immunization spending) at district and PHC levels.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(5.3)</td>
                                                        <td>Develop strategic planning from both public & private sector (human and capital) to support zero dose strategy and broader routine immunization programs to ensure sustainability post MICs funding.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(5.4)</td>
                                                        <td>Develop strategic costed planning at PHC level on targeting zero dose and restore RI to ensure sustainability post MICs funding.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(5.5)</td>
                                                        <td>Advocate budget allocation to support access and increase targeted immunization coverage (Coordinate with relevant units, programs, and ministries to act on findings and lessons learned from the immunization financing activities).</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(6.1)</td>
                                                        <td>Package and leverage lessons learned from implementation at select provinces, districts, and facilities for advocacy towards sustainability and scalability.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                    <tr>
                                                        <td>(6.2)</td>
                                                        <td>Workshops and technical assistance to facilitate and coordinate advocacy efforts to local government at selected provinces and districts aiming for local policy development and budget allocation to reduce zero dose children.</td>
                                                        <td class="text-center">✔</td>
                                                        <td class="text-center">✔</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <!-- <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div> -->
                </div>
            </footer>
        </div>
    </div>
    
    

    <script>
            
    </script>